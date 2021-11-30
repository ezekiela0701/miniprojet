<?php

namespace App\Form;

use App\Entity\TypeLogement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TypeLogementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name' ,  TextType::class,[
                'required' =>true,
                
                'label' =>"Type de logement",
                'attr' =>[
                    'class'=>'form-control',
                    'placeholder'=>"Prénoms",
                    'maxlength'=>'180',
                ]
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeLogement::class,
        ]);
    }
}
