<?php

namespace Event\EventBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isTopic', 'checkbox', [
                'label' => 'Topic?',
                'required' => false
            ])
            // @todo: add dependency validator Speech or Title is required
            ->add('speech', 'entity', [
                'class' => 'EventEventBundle:Speech',
                'property' => 'title',
                'empty_value' => 'Choose Speech',
                'required' => false
            ])
            ->add('title', 'text', ['required' => false])
            ->add('startDate', 'date', array(
                'attr' => array('class' => 'datepicker input-small'),
                'widget'   => 'single_text',
                'format' => 'MM/dd/y',
                'label' => 'Start Time'
            ))
            ->add('endDate', 'date', array(
                'attr' => array('class' => 'datepicker input-small'),
                'widget'   => 'single_text',
                'format' => 'MM/dd/y',
                'label' => 'End Time'
            ))

            // Add translation
            ->add('translations', 'collection', array(
                'type' => new ProgramTranslationType()
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Event\EventBundle\Entity\Program'
        ));
    }

    public function getName()
    {
        return 'program';
    }
}
