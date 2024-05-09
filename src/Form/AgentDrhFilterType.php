<?php

namespace App\Form;

use App\Entity\AgentsDrh;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentDrhFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
            ->add('username',options:['required' => false])
            ->add('email',options:['required' => false])
            ->add('numeroTelephone',options:['required' => false])
            ->add('nom',options:['required' => false])
            ->add('prenom',options:['required' => false])
            ->add('Appliquer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AgentsDrh::class,
        ]);
    }
}
