<?php
namespace App\Form;

use App\Entity\Fichiers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class FichiersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photoFile', VichFileType::class, [
                'label' => 'Photo',
                'required' => false,
                'allow_delete' => true,
                // 'serialize' => false,
                'download_uri' => true,
                'attr' => [
                    'class' => 'form-control',
                    'accept' => 'image/*'
                ],
            ])
            ->add('cvFile', VichFileType::class, [
                'label' => 'CV',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'attr' => [
                    'class' => 'form-control',
                     'accept' => '.pdf,.jpg,.doc,.docx,.png,.gif'
                ],
            ])
            ->add('passeportFile', VichFileType::class, [
                'label' => 'Passeport',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'attr' => [
                    'class' => 'form-control',
                    'accept' => '.pdf,.jpg,.doc,.docx,.png,.gif'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fichiers::class,
        ]);
    }
}