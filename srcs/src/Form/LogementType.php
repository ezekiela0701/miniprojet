<?php

namespace App\Form;

use App\Entity\Logement;
use App\Entity\TypeLogement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class LogementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numberclient', TextType::class,[
                'required' =>true,
                
                'label' =>"nombre de client",
                'attr' =>[
                    'class'=>'form-control',
                    'placeholder'=>"nombre de client",
                    'maxlength'=>'180',
                ]
            ])
            // ->add('startedDate')
            // ->add('endingDate')
            ->add('typeLogement', EntityType::class,[
                'class' => TypeLogement::class,
                'placeholder'=>"Type de logement",
                'choice_label'=>'name',
                'label'=>"Type de logement",
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true
            ])
            ->add('price' , IntegerType::class,[
                'required' =>true,
                
                'label' =>"Prix",
                'attr' =>[
                    'class'=>'form-control',
                    'placeholder'=>"Prix",
                    'maxlength'=>'180',
                ]
            ])
            ->add('status' ,  ChoiceType::class, [
                'required'=>true,
                'label'  => "Statut:",
                'attr'=>[
                    'class'=>'form-control',
                ],
                'choices'  => [
                    "Activer" => "1",
                    "Desativer" => "0",
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Logement::class,
        ]);
    }
}
