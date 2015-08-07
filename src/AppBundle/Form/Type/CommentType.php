<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Comment;

/**
 * Class CommentType
 */
class CommentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', null, array(
                'attr' => array(
                    'placeholder' => 'Mon commentaire...',
                    'rows' => 10,
                ),
            ))
        ;

        $builder->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event) {
            $data = $event->getData();
            $data->setContent('');
            $event->setData($data);
        });
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Comment::class,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_comment';
    }
}
