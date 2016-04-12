<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeSearchJobType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                "required" => false
            ))
            ->add('departments', EntityType::class, array(
                'class' => 'AppBundle:Department',
                'choice_label' => 'name',
                'multiple' => true
            ))
            ->add('job_type', EntityType::class, array(
                'class' => 'AppBundle:JobType',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ))
            ->add('job_field', EntityType::class, array(
                'class' => 'AppBundle:JobField',
                'choice_label' => 'name'
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'appbundle_home_search_job';
    }
}

