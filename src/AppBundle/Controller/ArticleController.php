<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ArticleController
 */
class ArticleController extends Controller
{
    /**
     * @Route("/articles/{slug}")
     * @Template("AppBundle:Article:show.html.twig")
     * @ParamConverter("article", options={"mapping": {"slug": "slug"}, "entity_manager" = "default"})
     */
    public function showAction(Article $article)
    {
        return array(
            'article' => $article,
        );
    }
}
