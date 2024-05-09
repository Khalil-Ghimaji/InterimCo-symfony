<?php

namespace App\Form;

use App\Entity\AgentsDrh;
use App\Entity\Clients;
use App\Entity\Contrats;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
            ->add('libelle')
            ->add('dateSoumission', null, [
                'widget' => 'single_text'
            ])
            ->add('dateReponse', null, [
                'widget' => 'single_text'
            ])
            ->add('etatContrat', ChoiceType::class, [
                'choices' => [
                    ''=>'',
                    'En cours de traitement' => 'En cours de traitement',
                    'Finalisé' => 'Finalisé',
                    'Accepté' => 'Accepté',
                    'Refusé' => 'Refusé',
                ],

            ])
            ->add('prix')

            ->add('client', EntityType::class, [
                'class' => Clients::class,
                'choice_label' => 'nom',
                'placeholder' => ' ',
            ])
            ->add('agentDrh', EntityType::class, [
                'class' => AgentsDrh::class,
                'choice_label' => function ($agent) {
                    return $agent->getNom() . ' ' . $agent->getPrenom() ;
                },
                'placeholder' => ' ',
            ])
            ->add('Appliquer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrats::class,
        ]);
    }
}
