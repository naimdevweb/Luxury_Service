<?php

namespace App\Form;

use App\Entity\Candidat;
use App\Entity\Candidature;
use App\Entity\offreemploi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statut')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('updated_at', null, [
                'widget' => 'single_text',
            ])
            ->add('deleted_at', null, [
                'widget' => 'single_text',
            ])
            ->add('candidat', EntityType::class, [
                'class' => Candidat::class,
                'choice_label' => 'id',
            ])
            ->add('OffreEmploi', EntityType::class, [
                'class' => offreemploi::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,
        ]);
    }
}
