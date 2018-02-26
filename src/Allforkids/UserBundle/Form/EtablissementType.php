<?php
// src/AppBundle/Form/RegistrationType.php

namespace Allforkids\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class EtablissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('num_tel')->add('typeEtablissement',ChoiceType::class, array(
        'label'=>'ETABLISSEMENT',
        'choices'  => array(
            'JARDIN D\'ENFANT' => 'Jardin DENFANT',
            'CLUB' => 'CLUB'
        ),

    ))->add('disponibilite')->add('adresse')->add('description');
    }


    public function getBlockPrefix()
    {
        return 'allforkids_parent_registration';
    }

}
