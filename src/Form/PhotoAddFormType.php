<?php

namespace App\Form;

use App\Entity\Photo;
use Doctrine\DBAL\Types\TextType;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class PhotoAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url',FileType::class)
            ->add('titre')
            ->add('theme')
            ->add('couleur',ColorType::class)
            ->add('localisation')
            ->add('submit', SubmitType::class,[
                'attr' => ['class' => 'btn btn-primary'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
