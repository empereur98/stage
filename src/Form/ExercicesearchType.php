<?php

namespace App\Form;

use App\Entity\Exercicesearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExercicesearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('motsearch',CheckboxType::class,[
                'attr'=>[
                    'class'=>'btn-check',
                    'id'=>'btn-check-outlined',
                    'autocomplete'=>"off"
                ],
            ])
        ;
    }
   // <input type="checkbox" class="btn-check" id="btn-check-outlined" autocomplete="off">
   // <label class="btn btn-outline-primary" for="btn-check-outlined">Single toggle</label><br>
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercicesearch::class,
        ]);
    }
}
