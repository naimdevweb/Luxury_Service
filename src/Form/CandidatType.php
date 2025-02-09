<?php

namespace App\Form;

use App\Entity\Candidat;
use DateTime;
use App\Entity\Categorie;
use App\Entity\ExperienceProfessionel;
use App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'attr' => [
                    'id' => 'last_name',
                    'class' => 'form-control'
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'required' => false,
                'attr' => [
                    'id' => 'last_name',
                    'class' => 'form-control'
                ],
            ])
            ->add('localisation', TextType::class, [
                'label' => 'Localisation',
                'required' => false,
                'attr' => [
                    'id' => 'current_location',
                    'class' => 'form-control'
                ],
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
                'attr' => [
                    'id' => 'address',
                    'class' => 'form-control'
                ],
            ])
            ->add('pays', TextType::class, [
                'label' => 'Pays',
                'required' => false,
                'attr' => [
                    'id' => 'country',
                    'class' => 'form-control'
                ],
            ])
            ->add('nationalite', TextType::class, [
                'label' => 'Nationalite',
                'required' => false,
                'attr' => [
                    'id' => 'nationality',
                    'class' => 'form-control'
                ],
            ])


            ->add('date_naissance', DateTimeType::class, [
                'label' => 'Date_naissance',
                'required' => false,
                'attr' => [
                    'id' => 'birth_date',
                    'class' => 'form-control'
                ],
            ])


            ->add('lieu_naissance', TextType::class, [
                'label' => 'Lieu_naissance',
                'required' => false,
                'attr' => [
                    'id' => 'birth_place',
                    'class' => 'form-control'
                ],
            ])

            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'id' => 'description',
                    'class' => 'form-control'
                ],
            ])

            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'required' => false,
                'choice_label' => 'nom',
                'expanded' => true,
                'label' => 'Genre',
                'attr' => [
                    'id' => 'gender',
                    'class' => 'form-control',
                    'data-placeholder' => 'Type in or Select your genre.'
                ],
            ])


            ->add('experience', EntityType::class, [
                'class' => ExperienceProfessionel::class,
                'choice_label' => 'nom',
              
                'expanded' => true,
                'label' => 'Experience',
                'attr' => [
                    'id' => 'experience',
                    'class' => 'form-control',
                    'data-placeholder' => 'Type in or Select your experience.'
                ],
            ])

            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                
                'choice_label' => 'nom',
                'expanded' => true,
                'label' => 'Interest in job sector',
                'attr' => [
                    'id' => 'job_sector',
                    'class' => 'form-control',
                    'data-placeholder' => 'Type in or Select job sector you would be interested in.'
                ],
            ])
            

            ->add('fichiers', FichiersType::class, [
                'label' => false,
                
            ]);
           


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class, // Assure-toi que ça pointe bien vers l'entité Candidat
        ]);
    }
}