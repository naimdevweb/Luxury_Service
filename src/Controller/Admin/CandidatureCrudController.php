<?php

namespace App\Controller\Admin;

use App\Entity\Candidature;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class CandidatureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidature::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        
            
                return [
                    IdField::new('id')->hideOnForm(),
                    ChoiceField::new('statut')
                        ->setChoices([
                            'En attente' => 'En attente',
                            'Acceptée' => 'Acceptée',
                            'Rejetée' => 'Rejetée',
                        ]),
                    DateTimeField::new('created_at'),
                    DateTimeField::new('updated_at'),
                    DateTimeField::new('deleted_at'),
                    AssociationField::new('candidat'),
                    AssociationField::new('offreEmploi'),
                ];
    }
    
}
