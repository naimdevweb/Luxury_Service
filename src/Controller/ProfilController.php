<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CandidatType;
use App\Entity\User;
use App\Entity\Candidat;
use App\Repository\CandidatRepository;

final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(
        CandidatRepository $candidatRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $candidat = $candidatRepository->findOneBy(['user' => $user->getId()]);
        if ($candidat === null) {
            $candidat = new Candidat();
            $candidat->setUser($user);
           
            $candidat->setUpdatedAt(new \DateTimeImmutable());

        }
       

        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
          if(  $candidat->getCreatedAt(new \DateTimeImmutable()) == null){
            $candidat->setCreatedAt(new \DateTimeImmutable());
          } 
         

          
$candidat->setUpdatedAt(new \DateTimeImmutable());

$fichiers = $candidat->getFichiers();
if ($fichiers) {
    if ($fichiers->getPasseportFile()) {
        $fichiers->setCheminPasseport($fichiers->getPasseportFile()->getFilename());
    }
    if ($fichiers->getCvFile()) {
        $fichiers->setCheminCv($fichiers->getCvFile()->getFilename());
    }
    if ($fichiers->getPhotoFile()) {
        $fichiers->setCheminPhoto($fichiers->getPhotoFile()->getFilename());
    }
    
}
            // dd($candidat);
           $entityManager->flush();

           

        }

        return $this->render('profil/profile.html.twig', [
            'form' => $form,
        ]);
    }
}