<?php

namespace App\Form;

use App\Entity\Estudiante;
use App\Entity\Expediente;
use App\Entity\Representante;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstudianteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('identificacion')
            ->add('apellidos')
            ->add('nombres')
            ->add('sexo')
            ->add('correo')
            ->add('telefono')
            ->add('fechaNacimiento')
            ->add('representante', EntityType::class, [
                'class' => Representante::class,
'choice_label' => 'id',
            ])
            ->add('expediente', EntityType::class, [
                'class' => Expediente::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Estudiante::class,
        ]);
    }
}
