<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class ReadingAdmin
 */
class ReadingAdmin extends Admin
{
    protected $baseRouteName = 'sonata_reading';
    protected $baseRoutePattern = 'readings';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('reader', 'doctrine_orm_model_autocomplete', array(), null, array(
                'property' => 'username'
            ))
            ->add('article', 'doctrine_orm_model_autocomplete', array(), null, array(
                'property' => 'title'
            ))
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
            ->add('reader')
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
            ->add('reader')
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
            ->add('reader')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
