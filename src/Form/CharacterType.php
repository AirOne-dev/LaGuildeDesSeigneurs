<?php

namespace App\Form;

use App\Entity\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('caste', TextType::class)
            ->add('knowledge', TextType::class)
            ->add('intelligence', TextType::class)
            ->add('life', IntegerType::class)
            ->add('image', TextType::class)
            ->add('kind', TextType::class)
            ->add('creation', DateTimeType::class)
            ->add('identifier', TextType::class)
            ->add('modification', DateTimeType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
            'allow_extra_fields' => true,
        ]);
    }
}
