<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('password')
            ->add('recordDate')
            ->add('lastConnection')
            ->add('status')
            ->add('birthDate')
            ->add('town')
            ->add('adressIp')
            ->add('apiToken')
            ->add('roles')
            ->add('evolution')
            ->add('mainIsle')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
