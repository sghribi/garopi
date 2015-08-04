<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $categories = $this->getDoctrine()->getRepository('AppBundle:ArticleCategory')->findAll();
        $last4Articles = $this->getDoctrine()->getRepository('AppBundle:Article')->getLastArticles(4);

        return array(
            'articlesWithCover' => $articlesWithCover,
            'categories' => $categories,
            'last4Articles' => $last4Articles,
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
    public function menuAction()
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:ArticleCategory')->findAll();

        return array(
            'categories' => $categories,
        );
    }
}
