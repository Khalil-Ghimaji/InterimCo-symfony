<?php

namespace App\Form;

use App\Entity\Competences;
use App\Entity\Employes;
use App\Entity\Prestations;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('dateInscription', null, [
                'widget' => 'single_text'
            ])
            ->add('adresse')
            ->add('numeroTelephone')
//            ->add('competences', CollectionType::class, [
//                'entry_type' => CompetenceFormType::class,
//                'allow_add' => true,
//                'allow_delete' => true,
//                'by_reference' => false,
//                'prototype' => true,
//                'prototype_name' => '__competence_name__',
//            ]);
            ->add('competences', EntityType::class, [
                'class' => Competences::class,
                'choice_label' => function ($competence) {
                    return $competence->getCompetence() . ' (' . $competence->getNiveauCompetence() . ')';
                },
                'multiple' => true,
                'expanded' => true,
                'allow_extra_fields' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employes::class,
        ]);
    }
}
