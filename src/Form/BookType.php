<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ref')
            ->add('title')
            ->add('publicationDate', null, [
                'widget' => 'single_text'
            ])
            ->add('Category',ChoiceType::class,[
                'choices'=>[
                    'SF'=>'Science Fiction',
                    'M'=>'Mystery',
                    'R'=>'Romance'
                ]
            ])
            ->add('id_Author', EntityType::class, [
                'class' => Author::class,
                'placeholder'=>'titre',
                'choice_label' => 'username',
                //'expanded'=>true,
                //'multiple'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
