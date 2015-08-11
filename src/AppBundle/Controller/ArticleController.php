<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Reading;
use AppBundle\Form\Type\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ArticleController
 */
class ArticleController extends Controller
{
    /**
     * @Route("/articles/{legacyId}", requirements={"legacyId": "\d+"})
     * @ParamConverter("article", options={"mapping": {"legacyId": "legacyId"}, "entity_manager" = "default"})
     */
    public function showLegacyArticleAction(Article $article)
    {
        return $this->redirectToRoute('app_article_show', array('slug' => $article->getSlug()), Response::HTTP_MOVED_PERMANENTLY);
    }

    /**
     * @Route("/articles/{slug}")
     * @Template("AppBundle:Article:show.html.twig")
     * @ParamConverter("article", options={"mapping": {"slug": "slug"}, "entity_manager" = "default"})
     */
    public function showAction(Article $article, Request $request)
    {
        // @TODO: move this in service/event
        $em = $this->getDoctrine()->getManager();
        $em->persist(new Reading($this->getUser(), $article));
        $em->flush();

        // Comment to highlight
        $highlight = null;
        $comment = new Comment();

        $form = $this->createForm(new CommentType(), $comment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $article->addComment($comment);
            $comment->setAuthor($this->getUser());
            $em->persist($comment);
            $em->flush();

            // Remove field after persist
            $form = $this->createForm(new CommentType(), new Comment());
            $highlight = $comment;
        }

        return array(
            'article' => $article,
            'form' => $form->createView(),
            'highlight' => $highlight,
        );
    }
}
