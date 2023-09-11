<?php

namespace App\Form;

use App\Entity\Vocabulaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VocabulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mot')
            ->add('traduction')
            ->add('audio')
            ->add('exemple')
            ->add('niveau_difficulte')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vocabulaire::class,
        ]);
    }
}
