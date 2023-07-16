<?php

namespace App\Form;

use App\Entity\HolidaysPeriod;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HolidaysPeriodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start', DateType::class,[
                'label' => 'Début',
                'widget' => 'single_text'
            ])
            ->add('end', DateType::class,[
                'label' => 'Fin',
                'widget' => 'single_text'
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HolidaysPeriod::class,
        ]);
    }
}
