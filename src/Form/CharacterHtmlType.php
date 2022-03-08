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
            ->add('caste', TextType::class, array('required' => false,'help' => 'Caste du Character'))
            ->add('knowledge', IntegerType::class, array('required' => false))
            ->add('intelligence', IntegerType::class, array('required' => false,'help' => 'Niveau d\'intelligence du Character (1-250)','attr' => array('min' => 1,'max' => 250)))
            ->add('life', IntegerType::class, array('required' => false,'label' => 'Niveau de vie','attr' => array('min' => 1,'max' => 250,'placeholder' => 'Niveau de vie du Character (1-250)')))
            ->add('image', TextType::class, array('required' => false))
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('kind', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
