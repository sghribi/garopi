<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CommentController
 */
class CommentController extends Controller
{
    /**
     * @Route("/comments/{id}", requirements={"id" = "\d+"}, options={"expose" = true})
     * @Method("DELETE")
     */
    public function removeAction(Comment $comment)
    {
        if ($comment->getAuthor() != $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(array('KO'), Response::HTTP_FORBIDDEN);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        return new JsonResponse(array('OK'));
    }
}
