<?php

namespace App\Form;

use App\Entity\Unit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('picture')
            ->add('damage')
            ->add('health')
            ->add('woodCost')
            ->add('stoneCost')
            ->add('metalCost')
            ->add('foodConsumption')
            ->add('trainingTime')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Unit::class,
        ]);
    }
}
