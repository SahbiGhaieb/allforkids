<?php
// src/AppBundle/Form/RegistrationType.php

namespace Allforkids\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Parent' => 'Parent',
                    'Etablissement' => 'Etablissement',
                ),
            ));
    }


    public function configureOptions(OptionsResolver $resolver)
    {

    }


    public function getName()
    {
        return $this->getBlockPrefix();
    }

}
