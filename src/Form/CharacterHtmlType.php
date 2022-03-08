<?php

namespace App\Form;

use App\Entity\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CharacterHtmlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'required' => false,
                'label' => 'Nom'
            ))
            ->add('surname', TextType::class, array(
                'required' => false,
                'label' => 'Prénom'
            ))
            ->add('caste', TextType::class, array(
                'required' => false,
                'label' => 'Race'
            ))
            ->add('knowledge', TextType::class, array(
                'required' => false,
                'label' => 'Compétence'
            ))
            ->add('intelligence', IntegerType::class, array(
                'required' => false,
                'label' => 'Niveau d\'intelligence',
                'help' => '(entre 1 et 250)',
                'attr' => array(
                    'min' => 1,
                    'max' => 250
                )
            ))
            ->add('life', IntegerType::class, array(
                'required' => false,
                'label' => 'Niveau de vie',
                'help' => '(entre 1 et 250)',
                'attr' => array(
                    'min' => 1,
                    'max' => 250
                )
            ))
            ->add('image', TextType::class, array(
                'required' => false,
                'label' => 'Chemin de l\'image'
            ))
            ->add('kind', TextType::class, array(
                'required' => false,
                'label' => 'Sexe',
                'help' => '(Dame - Homme)',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
