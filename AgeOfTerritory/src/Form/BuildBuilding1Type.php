<?php

namespace App\Form;

use App\Entity\BuildBuilding;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildBuilding1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('levelBuilding')
            ->add('woodCost')
            ->add('stoneCost')
            ->add('metalCost')
            ->add('buildingProd')
            ->add('buildTime')
            ->add('building')
            ->add('isle')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BuildBuilding::class,
        ]);
    }
}
