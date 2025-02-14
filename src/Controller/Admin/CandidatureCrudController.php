<?php
namespace App\Controller\Admin;

use App\Entity\Candidature;
use App\Repository\CandidatRepository;
use App\Repository\CandidatureRepository;
use App\Repository\OffreEmploiRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
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
                 ->innerJoin('entity.candidat', 'candidat')
                 ->andWhere('o.client = :client')
                 ->setParameter('client', $this->security->getUser()->getClient());

        return $response;
    }

    public function configureFields(string $pageName): iterable
    {
        $user = $this->security->getUser();
        $client = $user->getClient();

        return [
            AssociationField::new('candidat')
                ->setFormTypeOption('query_builder', function (CandidatRepository $candidatRepository) use ($client) {
                    return $candidatRepository->createQueryBuilder('c')
                        ->innerJoin('c.candidature', 'ca')
                        ->innerJoin('ca.offreEmploi', 'o')
                        ->andWhere('o.client = :client')
                        ->setParameter('client', $client);
                })
                ->setFormTypeOption('disabled', true), // Rendre le champ en lecture seule
            AssociationField::new('offreEmploi')
                ->setFormTypeOption('query_builder', function (OffreEmploiRepository $offreEmploiRepository) use ($client) {
                    return $offreEmploiRepository->createQueryBuilder('o')
                        ->andWhere('o.client = :client')
                        ->setParameter('client', $client);
                })
                ->setFormTypeOption('disabled', true), // Rendre le champ en lecture seule
            ImageField::new('candidat.fichiers.chemin_cv', 'CV')
                ->setBasePath('uploads/cvs')
                ->setUploadDir('public/uploads/cvs')
                ->setTextAlign('center')
                ->setFormTypeOption('allow_delete', false)
                ->setFormTypeOption('disabled', true), // Rendre le champ en lecture seule

            ImageField::new('candidat.fichiers.chemin_passeport', 'PASSEPORT')
                ->setBasePath('uploads/passeports')
                ->setUploadDir('public/uploads/passeports')
                ->setTextAlign('center')
                ->setFormTypeOption('allow_delete', false) // Rendre le champ en lecture seule
                ->setFormTypeOption('disabled', true), // Rendre le champ en lecture seule
                
            ChoiceField::new('statut')
                ->setChoices([
                    'En attente' => 'En attente',
                    'Acceptée' => 'Acceptée',
                    'Rejetée' => 'Rejetée',
                ]),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW); // Désactiver l'action NEW pour empêcher l'ajout de nouvelles candidatures
    }
}