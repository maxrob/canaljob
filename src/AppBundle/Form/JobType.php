<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'required' => true,
            ))
            ->add('address', 'text', array(
                'required' => true,
            ))
            ->add('latitude', 'number', array(
                'scale' => 20,
                'required' => true,
            ))
            ->add('longitude', 'number', array(
                'scale' => 20,
                'required' => true,
            ))
            ->add('zip', 'text')
            ->add('city', 'text', array(
                'required' => true,
            ))
            ->add('description', 'textarea', array(
                'required' => true,
            ))
            ->add('prerequisite', 'textarea', array(
                'required' => true,
            ))
            ->add('beginDate', 'datetime', array(
                'input' => 'datetime',
                'format' => 'yyyy-MM-dd HH:mm'
            ))
            ->add('endDate', 'datetime')
            ->add('url', 'text')
            ->add('mail', 'email')
            ->add('isGeoloc', 'choice', array(
                'choices' => array(
                    true,
                    false
                ),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('salaryMin', 'number')
            ->add('salaryMax', 'number')
            ->add('salaryType', 'text')
            ->add('company', EntityType::class, array(
                'class' => 'AppBundle:Company',
                'choice_label' => 'name',
            ))
            ->add('department', EntityType::class, array(
                'class' => 'AppBundle:Department',
                'choice_label' => 'name',
            ))
            ->add('jobField', EntityType::class, array(
                'class' => 'AppBundle:jobField',
                'choice_label' => 'name',
            ))
            ->add('jobType', EntityType::class, array(
                'class' => 'AppBundle:jobType',
                'choice_label' => 'name',
            ))
            ->add('fluxJobField', EntityType::class, array(
                'class' => 'AppBundle:fluxJobField',
                'choice_label' => 'name',
            ))
            ->add('fluxJobType', EntityType::class, array(
                'class' => 'AppBundle:fluxJobType',
                'choice_label' => 'name',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Job',
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'appbundle_job';
    }
}
