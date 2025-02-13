<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\OffreEmploi;
use App\Entity\User;
use App\Repository\OffreEmploiRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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
use Doctrine\ORM\EntityManagerInterface;

class OffreEmploiCrudController extends AbstractCrudController
{
    private Security $security;
    private EntityRepository $entityRepository;
    private OffreEmploiRepository $offreEmploiRepository;

    public function __construct(Security $security, EntityRepository $entityRepository, OffreEmploiRepository $offreEmploiRepository)
    {
        $this->security = $security;
        $this->entityRepository = $entityRepository;
        $this->offreEmploiRepository = $offreEmploiRepository;
    }

    public static function getEntityFqcn(): string
    {
        return OffreEmploi::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $user = $this->security->getUser();
        $existingOffre = $this->offreEmploiRepository->findOneBy(['client' => $user->getClient()]);

        if ($existingOffre) {
            $this->addFlash('danger', 'Vous avez déjà créé une offre d\'emploi.');
            return null;  // Ou rediriger vers une autre page
        }

        $offreEmploi = new OffreEmploi();
        $offreEmploi->setClient($user->getClient());
        return $offreEmploi;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_RECRUTEUR');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->entityRepository->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere('entity.client = :client')->setParameter('client', $this->security->getUser()->getClient());

        return $response;
    }

    public function configureActions(Actions $actions): Actions
    {
        $user = $this->security->getUser();
        $existingOffre = $this->offreEmploiRepository->findOneBy(['client' => $user->getClient()]);

        if ($existingOffre) {
            return $actions
                ->disable(Action::NEW);
        }

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            TextField::new('description'),
            TextField::new('localisation'),
            TextField::new('note'),
            NumberField::new('salaire'),
            NumberField::new('reference'),
            BooleanField::new('active'),
            AssociationField::new('categorie'),
            AssociationField::new('typeContrat'),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof OffreEmploi) {
            $user = $this->security->getUser();
            $entityInstance->setClient($user->getClient());
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof OffreEmploi) {
            $user = $this->security->getUser();
            $entityInstance->setClient($user->getClient());
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
}