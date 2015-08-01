<?php

namespace AppBundle\Admin;

use FOS\UserBundle\Model\UserManagerInterface;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class ArticleAdmin
 */
class ArticleAdmin extends Admin
{
    protected $baseRouteName = 'sonata_article';
    protected $baseRoutePattern = 'articles';

    /** @var UserManagerInterface */
    protected $userManager;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('title')
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
            ->add('category', null, array('editable' => true))
            ->add('authorName', null, array('editable' => true))
            ->add('createdAt')
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
            ->add('content')
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
            ->add('category')
            ->add('authorName')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('content')
        ;
    }
}
