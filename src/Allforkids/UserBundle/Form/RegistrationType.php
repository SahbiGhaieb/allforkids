<?php
// src/AppBundle/Form/RegistrationType.php

namespace Allforkids\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')->add('image',FileType::class,array('label'=>'inserer une image'))->add('prenom')->add('roles', ChoiceType::class, array(
            'choices'  => array(
                'PARENT' => 'ROLE_PARENT',
                'ETABLISSEMENT' => 'ROLE_ETABLISSEMENT',
            ),
            'choices_as_values' => true,
            'multiple'=> true,
            ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'allforkids_user_registration';
    }

}
