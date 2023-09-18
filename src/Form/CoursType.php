<?php

namespace App\Form;

use App\Entity\Cours;
use App\Enum\NiveauEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Langue;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('langue',EntityType::class,[
                'class'=>Langue::class,
                'choice_label'=>'nom',
                'choice_name'=>'nom',
                'multiple'=>false
            ])
            ->add('niveau',ChoiceType::class,[
                'label'=>'Niveau',
                'choices'=>[
                     'FACILE'=> NiveauEnum::FACILE,
                     'DIFFICILE'=>NiveauEnum::DIFFICILE
                ],
            ])
            ->add('objectif')
            ->add('save',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
