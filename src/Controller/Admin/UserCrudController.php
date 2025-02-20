<?php
namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            //  BooleanField::new('isVerified'),
            TextField::new('password', 'Password')
                ->setFormType(RepeatedType::class)
                ->setFormTypeOptions([
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat Password'],
                ])
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->onlyOnForms(),
            ChoiceField::new('roles')
                ->setChoices([
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                    'Recruteur' => 'ROLE_RECRUTEUR',
                ])
                ->allowMultipleChoices()
                ->renderAsBadges(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) return;
        

       
      $entityInstance->setIsVerified(true);

        $entityInstance->setPassword(
            $this->passwordHasher->hashPassword(
                $entityInstance,
                $entityInstance->getPassword(),
              
            )
        );

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) return;

        $entityInstance->setPassword(
            $this->passwordHasher->hashPassword(
                $entityInstance,
                $entityInstance->getPassword()
            )
        );

        parent::updateEntity($entityManager, $entityInstance);
    }
}