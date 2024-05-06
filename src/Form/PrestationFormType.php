<?php

namespace App\Form;

use App\Entity\Competences;
use App\Entity\Prestations;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('competence', EntityType::class, [
                'class' => Competences::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.competence', 'ASC')
                        ->orderBy('c.niveauCompetence','ASC');
                },
                'choice_label' => function (Competences $competence) {
                    return $competence->getCompetence() . ' - ' . $competence->getNiveauCompetence();
                },
                'placeholder' => 'Select competence', // Optional placeholder text
            ])
            ->add('dateDebut',DateType::class,[
                'widget'=>'single_text'
            ])
            ->add('dateFin',DateType::class,[
                'widget'=>'single_text'
            ])
            ->add('duree');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prestations::class,
        ]);
    }
}
