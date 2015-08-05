<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

class ArticleMediaAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('media', 'sonata_type_model_list', array(
                'required' => false
            ), array(
                'link_parameters' => array(
                    'context' => 'default'
                )
            ))
            ->add('legend')
            ->add('position', 'hidden');
    }
}