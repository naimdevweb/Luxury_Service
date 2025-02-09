<?php

namespace App\Controller\Admin;

use App\Entity\TypeContrat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TypeContratCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeContrat::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            
        ];
    }
    
}
