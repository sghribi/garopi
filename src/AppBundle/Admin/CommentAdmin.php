<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class CommentAdmin
 */
class CommentAdmin extends Admin
{
    protected $baseRouteName = 'sonata_comment';
    protected $baseRoutePattern = 'comments';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('author', 'doctrine_orm_model_autocomplete', array(), null, array(
                'property' => 'username'
            ))
            ->add('article', 'doctrine_orm_model_autocomplete', array(), null, array(
                'property' => 'title'
            ))
            ->add('content')
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
            ->add('article')
            ->add('author')
            ->add('content')
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
            ->add('article')
            ->add('author')
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
            ->add('article')
            ->add('author')
            ->add('content')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
