<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ArticleCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 */
class CategoryController extends Controller
{
    /**
     * @Route("/categories/{slug}")
     * @Template("AppBundle:Category:show.html.twig")
     * @ParamConverter("category", options={"mapping": {"slug": "slug"}, "entity_manager" = "default"})
     */
    public function showAction(ArticleCategory $category, Request $request)
    {
        $paginator  = $this->get('knp_paginator');
        $articles = $paginator->paginate(
            $this->getDoctrine()->getRepository('AppBundle:Article')->getQbArticlesInCategory($category),
            $request->query->getInt('page', 1),
            10
        );

        return array(
            'category' => $category,
            'articles' => $articles,
        );
    }
}
