<?php

namespace App\Controller\Admin;

use App\Entity\Candidature;
use App\Repository\CandidatureRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;

class CandidatureCrudController extends AbstractCrudController
{
    private Security $security;
    private EntityRepository $entityRepository;
    private CandidatureRepository $candidatureRepository;

    public function __construct(Security $security, EntityRepository $entityRepository, CandidatureRepository $candidatureRepository)
    {
        $this->security = $security;
        $this->entityRepository = $entityRepository;
        $this->candidatureRepository = $candidatureRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Candidature::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_RECRUTEUR');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->entityRepository->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->innerJoin('entity.offreEmploi', 'o')
                 ->andWhere('o.client = :client')
                 ->setParameter('client', $this->security->getUser()->getClient());

        return $response;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions;
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