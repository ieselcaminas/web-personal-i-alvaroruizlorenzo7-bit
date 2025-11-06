<?php

namespace App\Form;

use App\Entity\Casa;
use App\Entity\Provincia;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CasaFormType extends AbstractType
{
    
         public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('direccion', TextType::class)
            ->add('precio', NumberType::class)
            ->add('descripcion', TextareaType::class)
            ->add('provincia', EntityType::class, [
                'class' => Provincia::class,
                'choice_label' => 'nombre'
            ])
            ->add('guardar', SubmitType::class, ['label' => 'Guardar']);
           
    }
}
