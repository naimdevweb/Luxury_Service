<?php

namespace App\Form;

use App\Entity\Candidat;
use DateTime;
use App\Entity\Categorie;
use App\Entity\ExperienceProfessionel;
use App\Entity\Genre;
use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
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
                'empty_data' => '',
                'attr' => [
                    'id' => 'last_name',
                    'class' => 'form-control'
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'id' => 'last_name',
                    'class' => 'form-control'
                ],
            ])
            ->add('localisation', TextType::class, [
                'label' => 'Localisation',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'id' => 'current_location',
                    'class' => 'form-control'
                ],
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'id' => 'address',
                    'class' => 'form-control'
                ],
            ])
            ->add('pays', TextType::class, [
                'label' => 'Pays',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'id' => 'country',
                    'class' => 'form-control'
                ],
            ])
            ->add('nationalite', TextType::class, [
                'label' => 'Nationalite',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'id' => 'nationality',
                    'class' => 'form-control'
                ],
            ])


            ->add('date_naissance', DateType::class, [
                'label' => 'Date_naissance',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'id' => 'birth_date',
                    'class' => 'form-control'
                ],
            ])


            ->add('lieu_naissance', TextType::class, [
                'label' => 'Lieu_naissance',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'id' => 'birth_place',
                    'class' => 'form-control'
                ],
            ])

            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'id' => 'description',
                    'class' => 'form-control'
                ],
            ])

            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'nom',
                'label' => 'Genre',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'id' => 'gender',
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choose an option.'
            ])


            ->add('experience', EntityType::class, [
                'class' => ExperienceProfessionel::class,
                'choice_label' => 'nom',
                'label' => 'Experience',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'id' => 'experience',
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choose an option.'
            ])

             ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'label' => 'Interest in job sector',
                'required' => false,
                'empty_data' => '',
                'attr' => [
                    'id' => 'job_sector',
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choose an option.'
            ])

           

             ->add('user', UserType::class, [
                'label' => false,
            ])

            ->add('fichiers', FichiersType::class, [
                'label' => false,
                
            ]);

         
           


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class, 
        ]);
    }

  
    }   
