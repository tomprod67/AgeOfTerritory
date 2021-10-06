<?php

namespace App\Form;

use App\Entity\Defense;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DefenseType extends AbstractType
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
            ->add('buildTime')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Defense::class,
        ]);
    }
}
