<?php
namespace App\Controller;

use App\Entity\Candidat;
use App\Repository\CategorieRepository;
use App\Repository\OffreEmploiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class JobsController extends AbstractController
{
    #[Route('/jobs', name: 'app_jobs')]
    public function index(
        CategorieRepository $categorieRepository,
        OffreEmploiRepository $offreEmploiRepository,
        EntityManagerInterface $entityManager,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $categories = $categorieRepository->findAll();

        $queryBuilder = $offreEmploiRepository->findAllJobs('o');
           

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );

        $user = $this->getUser();
        $candidat = $entityManager->getRepository(Candidat::class)->findOneBy(['user' => $user]);

        $isProfileComplete = $candidat && $candidat->isProfileComplete();

        return $this->render('jobs/index.html.twig', [
            'categories' => $categories,
            'pagination' => $pagination,
            'isProfileComplete' => $isProfileComplete,
        ]);
    }
}