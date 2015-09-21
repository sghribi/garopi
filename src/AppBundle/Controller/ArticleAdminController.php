<?php

namespace AppBundle\Controller;

use AppBundle\Events;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Article;

class ArticleAdminController extends Controller
{
    public function sendEmailAction()
    {
        /** @var Article $object */
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException();
        }

        if ($object->getEmailSent()) {
            $this->addFlash('sonata_flash_error', 'Un mail a déjà été envoyé.');
            return new RedirectResponse($this->admin->generateUrl('list'));
        }

        $this->get('event_dispatcher')->dispatch(Events::ARTICLE_PUBLISHED, new Events\ArticleEvent($object));

        $object->setEmailSent(true);
        $this->admin->update($object);

        $this->addFlash('sonata_flash_success', 'Mail envoyé !');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
