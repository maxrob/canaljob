<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeSearchFormationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->path = $options["request"]->getPathInfo();

        $builder
            ->add('title', 'text', array(
                "required" => false
            ))
            ->add('formation_type', EntityType::class, array(
                'class' => 'AppBundle:FormationType',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ))
        ;

        if($this->path === "/search") {
            $builder
                ->add('departments', EntityType::class, array(
                    'class' => 'AppBundle:Department',
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true
                ))
                ->add('formation_field', EntityType::class, array(
                    'class' => 'AppBundle:FormationField',
                    'choice_label' => 'name',
                    'expanded' => true
                ))
            ;
        } else {
            $builder
                ->add('departments', EntityType::class, array(
                    'class' => 'AppBundle:Department',
                    'choice_label' => 'name',
                    'multiple' => true,
                ))
                ->add('formation_field', EntityType::class, array(
                    'class' => 'AppBundle:FormationField',
                    'choice_label' => 'name'
                ))
            ;
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Formation'
        ));

        $resolver->setRequired([
            'request'
        ]);

        $resolver->setAllowedTypes([
            "request" => 'Symfony\Component\HttpFoundation\Request'
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'appbundle_home_search_formation';
    }
}

