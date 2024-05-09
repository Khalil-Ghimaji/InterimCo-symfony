<?php

namespace App\Form;

use App\Entity\Competences;
use App\Entity\Employes;
use App\Entity\Prestations;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeFilterType extends AbstractType
{
    private array $competences;

    public function __construct(array  $competences=[])
    {
        $this->competences = $competences;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
            ->add('nom',options:['required' => false])
            ->add('prenom',options:['required' => false])
            ->add('email',options:['required' => false])
            ->add('dateInscription', null, [
                'widget' => 'single_text'
            ])
            ->add('adresse',options:['required' => false])
            ->add('numeroTelephone',options:['required' => false])
            ->add('competences', EntityType::class, [
                'class' => Competences::class,
                'choice_label' => function ($competence) {
                    return $competence->getCompetence() . ' (' . $competence->getNiveauCompetence() . ')';
                },
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('Appliquer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employes::class,
            'competences' => [],
        ]);
    }
}
