<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\ArticleMedia;
use AppBundle\Entity\User;
use AppBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Swift_Mailer;
use Twig_Environment;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\RouterInterface;
use AppBundle\Events\ArticleEvent;
use Sonata\MediaBundle\Twig\Extension\MediaExtension;

/**
 * Class EmailListener
 */
class EmailListener implements EventSubscriberInterface
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var MediaExtension
     */
    private $sonataMediaTwigExtension;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var string
     */
    private $rootDir;

    /**
     * @param Swift_Mailer      $mailer
     * @param RouterInterface   $router
     * @param Twig_Environment  $twig
     * @param MediaExtension    $sonataMediaTwigExtension
     * @param EntityManager     $em
     * @param array             $parameters
     * @param string            $rootDir
     */
    public function __construct(
        Swift_Mailer $mailer,
        RouterInterface $router,
        Twig_Environment $twig,
        MediaExtension $sonataMediaTwigExtension,
        EntityManager $em,
        array $parameters,
        $rootDir
    )
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->twig = $twig;
        $this->sonataMediaTwigExtension = $sonataMediaTwigExtension;
        $this->em = $em;
        $this->parameters = $parameters;
        $this->rootDir = $rootDir;
    }
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::ARTICLE_PUBLISHED => array(
                array('sendNewArticleMessage')
            ),
        );
    }

    /**
     * @param ArticleEvent $articleEvent
     */
    public function sendNewArticleMessage(ArticleEvent $articleEvent)
    {
        $url = $this->router->generate('app_article_show', array('slug' => $articleEvent->getArticle()->getSlug()), true);
        $context = array(
            'article'   => $articleEvent->getArticle(),
            'url'       => $url
        );

        /** @var User[] $moderators */
        $users = $this->em->getRepository('AppBundle:User')->findBy(array('wantsToReceiveMails' => true));
        $usersEmails = array();
        foreach ($users as $user) {
            $usersEmails[$user->getEmail()] = sprintf('%s %s', $user->getFirstName(), $user->getLastName());
        }

        if ($articleEvent->getArticle()->getMedias()->count() > 0) {
            /** @var ArticleMedia $articleMedia */
            $articleMedia = $articleEvent->getArticle()->getMedias()->first();
            $context['media'] = $articleMedia->getMedia();
       }

        $this->sendMessage(
            $this->parameters['email']['template'],
            $context,
            $this->parameters['email']['from_email']['address'],
            $this->parameters['email']['from_email']['sender_name'],
            array(),
            $usersEmails
        );
    }

    /**
     * @param string $templateName
     * @param array  $context
     * @param string $fromEmail
     * @param string $senderName
     * @param string $toEmail
     * @param string $bccEmail
     */
    protected function sendMessage($templateName, $context, $fromEmail, $senderName, $toEmail, $bccEmail)
    {
        $message = \Swift_Message::newInstance();

        if (isset($context['media'])) {
            $path = sprintf(
                '%s/../web%s',
                $this->rootDir,
                $this->sonataMediaTwigExtension->path($context['media'], 'cover')
            );
            $cid = $message->embed(\Swift_Image::fromPath($path));
            $context['cid'] = $cid;
        }

        $context = $this->twig->mergeGlobals($context);

        $template = $this->twig->loadTemplate($templateName);
        $subject = $template->renderBlock('subject', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $message
            ->setSubject($subject)
            ->setFrom($fromEmail, $senderName)
            ->setSender($fromEmail, $senderName)
            ->setTo($toEmail)
            ->setBcc($bccEmail)
            ->setBody($htmlBody, 'text/html');

        $this->mailer->send($message);
    }
}
