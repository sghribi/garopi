<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\ArticleCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomepageController
 */
class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("AppBundle:Homepage:index.html.twig")
     */
    public function indexAction()
    {
        $articlesWithCover = $this->getDoctrine()->getRepository('AppBundle:Article')->getLastArticlesWithCover();
        $last3Articles = $this->getDoctrine()->getRepository('AppBundle:Article')->getLastArticles(3);
        $categories = $this->getDoctrine()->getRepository('AppBundle:ArticleCategory')->findBy(array(), array('order' => 'ASC'));
        $quote = $this->getDoctrine()->getRepository('AppBundle:Quote')->getOneRandomQuote();
        $last3Comments = $this->getDoctrine()->getRepository('AppBundle:Comment')->getLastComments(3);
        $mostRead = $this->getDoctrine()->getRepository('AppBundle:Article')->getMostRead(3);
        $mostCommented = $this->getDoctrine()->getRepository('AppBundle:Article')->getMostCommented(3);

        //@TODO: can be optimised...
        $articlesByCategory = array();
        foreach ($categories as $category) {
            $articlesByCategory[$category->getSlug()] = $this->getDoctrine()->getRepository('AppBundle:Article')->getLastArticlesInCategory($category, 2);
        }

        $horoscopes = $this->getDoctrine()->getRepository('AppBundle:Horoscope')->findBy(array(), array('letter' => 'ASC'));

        return array(
            'articlesWithCover' => $articlesWithCover,
            'categories' => $categories,
            'last3Articles' => $last3Articles,
            'articlesByCategory' => $articlesByCategory,
            'horoscopes' => $horoscopes,
            'quote' => $quote,
            'comments' => $last3Comments,
            'mostRead' => $mostRead,
            'mostCommented' => $mostCommented,
        );
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();

        return $this->redirect('https://cas.my.ecp.fr/logout?service=' . $this->generateUrl('homepage', array(), true));
    }

    /**
     * @Template("AppBundle::menu.html.twig")
     */
    public function menuAction(ArticleCategory $currentCategory = null)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:ArticleCategory')->findBy(array(), array('order' => 'ASC'));

        return array(
            'categories' => $categories,
            'currentCategory' => $currentCategory,
        );
    }

    /**
     * @Route("/settings/notify-by-mail", options={"expose": true})
     * @Method("PUT")
     */
    public function notifyByMailAction()
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->getUser();

        if ($user->getWantsToReceiveMails()) {
            $user->setWantsToReceiveMails(false);
        } else {
            $user->setWantsToReceiveMails(true);
        }

        $em->persist($user);
        $em->flush();

        return new JsonResponse(array('OK'));
    }
}
