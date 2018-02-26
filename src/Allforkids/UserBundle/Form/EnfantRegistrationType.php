<?php
// src/AppBundle/Form/RegistrationType.php

namespace Allforkids\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class EnfantRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')->add('prenom')->add('email',EmailType::class)->add('password',PasswordType::class)
            ->add('username')
        ->add('submit',SubmitType::class);
    }



    public function getBlockPrefix()
    {
        return 'allforkids_user_registration';
    }

}
