<?php

namespace App\Controller\Admin;

use App\Entity\Client;

use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom_de_la_societe'),
            TextField::new('type_activite'),
            TextField::new('nom_du_contact'),
            TextField::new('post'),
            TextField::new('numero_du_contact'),
            TextField::new('email_du_contact'),
            TextField::new('notes'),
            AssociationField::new('user')
                ->setCrudController(UserCrudController::class)
                ->setFormTypeOption('choice_label', 'email')
                ->setFormTypeOption('query_builder', function (UserRepository $userRepository) {
                    return $userRepository->createQueryBuilder('u')
                        ->orderBy('u.email', 'ASC');
                }),
        ];
    }
    
    


}
