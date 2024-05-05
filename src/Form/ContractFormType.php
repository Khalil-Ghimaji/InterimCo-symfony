<?php

namespace App\Form;

use App\Entity\Contrats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('date_soumission')
            ->add('date_reponse')
            ->add('etat_contrat')
            ->add('prix')
            ->add('prix_final')
            ->add('client')
            ->add('agent_drh')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrats::class,
        ]);
    }
}
