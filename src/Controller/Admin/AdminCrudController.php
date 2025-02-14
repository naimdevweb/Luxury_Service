<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class AdminCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

   
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW); // Désactiver l'action NEW pour empêcher l'ajout de nouveaux clients
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('nom_de_la_societe'),
            TextField::new('type_activite'),
            TextField::new('nom_du_contact'),
            TextField::new('post'),
            TextField::new('numero_du_contact'),
            TextField::new('email_du_contact'),
            TextEditorField::new('notes'),
        ];
    }
}