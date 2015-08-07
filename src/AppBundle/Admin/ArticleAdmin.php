<?php

namespace AppBundle\Admin;

use FOS\UserBundle\Model\UserManagerInterface;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use AppBundle\Entity\ArticleMedia;

/**
 * Class ArticleAdmin
 */
class ArticleAdmin extends Admin
{
    protected $baseRouteName = 'sonata_article';
    protected $baseRoutePattern = 'articles';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('title')
            ->add('published')
            ->add('category', 'doctrine_orm_model_autocomplete', array(), null, array(
                'property' => 'name'
            ))
            ->add('authorName')
            ->add('createdAt')
        ;
    }
    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('title', null, array('editable' => true))
            ->add('slug')
            ->add('published', null, array('editable' => true))
            ->add('category', null, array('editable' => true))
            ->add('authorName', null, array('editable' => true))
            ->add('createdAt')
            ->add('nbComments')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('category')
            ->add('authorName')
            ->add('published', null, array(
                'required' => false,
            ))
            ->add('content', 'ckeditor', array(
                'attr' => array(
                    'class' => 'ckeditor',
                ),
            ))
            ->add('medias', 'sonata_type_collection', array(
                'required' => false,
                'label' => 'Medias (le premier correspond à la couverture)'
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable'  => 'position',
            ))
        ;
        ;
    }
    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('slug')
            ->add('published')
            ->add('category')
            ->add('authorName')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('content')
            ->add('comments')
        ;
    }

    public function prePersist($object)
    {
        /** @var ArticleMedia $media */
        foreach ($object->getMedias() as $media) {
            $media->setArticle($object);
        }
    }

    public function preUpdate($object)
    {
        /** @var ArticleMedia $media */
        foreach ($object->getMedias() as $media) {
            $media->setArticle($object);
        }
    }
}
