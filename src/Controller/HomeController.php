<?php

namespace App\Controller;

use App\Entity\OffreEmploi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine, CategorieRepository $categorieRepository): Response
    {
        $offres = $doctrine->getRepository(OffreEmploi::class)->findAll();
        $categories = $categorieRepository->findAll();

        return $this->render('home/index.html.twig', [
            'offres' => $offres,
            'categories' => $categories,
        ]);
    }
}