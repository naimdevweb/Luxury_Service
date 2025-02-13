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
        $offres = $offreEmploiRepository->findAllWithDetails();
        // dd($offres);

        // Ajoutez cette ligne pour vérifier les données
        //  dd($offres, $categories);


        // if($this->getUser() && $this->getUser()->getRoles()){
        //     $roles = $this->getUser()->getRoles();
        //     if (in_array('ROLE_RECRUTEUR', $roles) || in_array('ROLE_ADMIN', $roles)){
        //         return $this->redirectToRoute('admin');
                
        //     }
        // }


        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'offres' => $offres,
        ]);
    }
}