<?php
namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\OffreEmploiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategorieRepository $categorieRepository, OffreEmploiRepository $offreEmploiRepository): Response
    {
        $categories = $categorieRepository->findAll();
        $offres = $offreEmploiRepository->findAll();

        // Ajoutez cette ligne pour vérifier les données
        //  dd($offres, $categories);

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'offres' => $offres,
        ]);
    }
}