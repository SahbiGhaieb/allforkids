<?php
// src/AppBundle/Form/RegistrationType.php

namespace Allforkids\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')->add('prenom')->add('roles', ChoiceType::class, array(
            'choices'  => array(
                'PARENT' => 'ROLE_PARENT',
                'ENFANT' => 'ROLE_ENFANT',
                'ETABLISSEMENT' => 'ROLE_ETABLISSEMENT',
            )));
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
