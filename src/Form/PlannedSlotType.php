<?php

namespace App\Form;

use App\Entity\PlannedSlot;
use App\Entity\PlannedSlotCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlannedSlotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start', DateTimeType::class, [
                'label' => 'Début',
                'widget' => 'single_text'
            ])
            ->add('end', DateTimeType::class, [
                'label' => 'Fin',
                'widget' => 'single_text'
            ])
            ->add('plannedSlotCategory', EntityType::class, [
                'label' => 'Catégorie',
                'class' => PlannedSlotCategory::class,
                'placeholder' => 'Choisir une catégorie',
                'choice_label' => 'name'
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlannedSlot::class,
        ]);
    }
}
