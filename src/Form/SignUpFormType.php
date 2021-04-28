<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,
            ['attr' => [
                'placeholder'=>"Nom"]])
            ->add('prenom',TextType::class,
                ['attr' => [
                    'placeholder'=>"Prenom"]])
            ->add('bio',TextType::class,
                ['attr' => [
                'placeholder'=>"Nom"]])
            ->add('age',TextType::class,
                ['attr' => [
                    'placeholder'=>"Bio"]])
            ->add('tel',TextType::class,
                ['attr' => [
                    'placeholder'=>"Telephone"]])
            ->add('email',TextType::class,
                ['attr' => [
                    'placeholder'=>"Email"]])
            ->add('password',TextType::class,
                ['attr' => [
                    'placeholder'=>"Password"]])
            ->add('type',TextType::class,
                ['attr' => [
                    'placeholder'=>"Nom"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
