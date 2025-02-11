<?php
namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\OffreEmploi;
use App\Repository\CategorieRepository;
use App\Repository\OffreEmploiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class JobsController extends AbstractController
{
    #[Route('/jobs', name: 'app_jobs')]
    public function index(CategorieRepository $categorieRepository, OffreEmploiRepository $offreEmploiRepository, EntityManagerInterface $entityManager): Response
    {
        $categories = $categorieRepository->findAll();
        $offres = $offreEmploiRepository->findAll();

        $user = $this->getUser();
        $candidat = $entityManager->getRepository(Candidat::class)->findOneBy(['user' => $user]);

        $isProfileComplete = $candidat && $candidat->isProfileComplete();

        return $this->render('jobs/index.html.twig', [
            'categories' => $categories,
            'offres' => $offres,
            'isProfileComplete' => $isProfileComplete,
        ]);
    }

    
}