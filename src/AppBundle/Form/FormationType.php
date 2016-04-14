<?php

namespace AppBundle\Form;

use AppBundle\Entity\FormationPeriod;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
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
            ->add('latitude', 'text', array(
                'required' => true,
            ))
            ->add('longitude', 'text', array(
                'required' => true,
            ))
            ->add('zip', 'text')
            ->add('city', 'text', array(
                'required' => true,
            ))
            ->add('description', 'textarea', array(
                'required' => true,
            ))
            ->add('perspective', 'textarea', array(
                'required' => true,
            ))
            ->add('url', 'text')
            ->add('mail', 'email')
            ->add('isGeoloc', 'choice', array(
                'choices'  => array( 'Non' => false, 'Oui' => true),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('school', EntityType::class, array(
                'class' => 'AppBundle:School',
                'choice_label' => 'name',
            ))
            ->add('department', EntityType::class, array(
                'class' => 'AppBundle:Department',
                'choice_label' => 'name',
            ))
            ->add('fluxFormationField', EntityType::class, array(
                'class' => 'AppBundle:fluxFormationField',
                'choice_label' => 'name',
            ))
            ->add('fluxFormationType', EntityType::class, array(
                'class' => 'AppBundle:fluxFormationType',
                'choice_label' => 'name',
            ))
            ->add('formationField', EntityType::class, array(
                'class' => 'AppBundle:formationField',
                'choice_label' => 'name',
            ))
            ->add('formationType', EntityType::class, array(
                'class' => 'AppBundle:formationType',
                'choice_label' => 'name',
            ))
            ->add('formationPeriod','collection',array(
                'type' => new FormationPeriod(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Formation'
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'appbundle_formation';
    }
}
