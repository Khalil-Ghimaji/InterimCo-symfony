<?php

namespace App\Form;

use App\Entity\Prestations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_debut')
            ->add('date_fin')
            ->add('date_deb_finale')
            ->add('date_fin_finale')
            ->add('duree')
            ->add('prix')
            ->add('prix_final')
            ->add('description')
            ->add('competence')
            ->add('contrat')
            ->add('employes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prestations::class,
        ]);
    }
}
