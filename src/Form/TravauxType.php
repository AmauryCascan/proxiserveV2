<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\File;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\Travaux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TravauxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero')
            ->add('year')
            ->add('started_at')
            ->add('finished_at')
            ->add('price')
            ->add('rdv_at')
            ->add('commande')
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'name',
            ])
            ->add('secteur', EntityType::class, [
                'class' => Secteur::class,
                'choice_label' => 'name',
            ])
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'name',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ])
            ->add('file', FileType::class, [
                'label' => 'fileName',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Travaux::class,
        ]);
    }
}
