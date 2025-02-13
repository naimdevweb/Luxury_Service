<?php
namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\OffreEmploi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CandidatureType;
use App\Repository\CategorieRepository;

#[Route('/candidature')]
final class CandidatureController extends AbstractController
{
    #[Route('/postuler/{id}', name: 'candidature_postuler', methods: ['POST'])]
    public function postuler(Request $request, OffreEmploi $offre, EntityManagerInterface $entityManager, CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAll();
        $user = $this->getUser();
        $offres = $entityManager->getRepository(OffreEmploi::class)->findAllWithDetails();
        $candidat = $user->getCandidat();

        if (!$candidat || !$candidat->isProfileComplete()) {
            $this->addFlash('error', 'Vous devez compléter votre profil avant de postuler à une offre.');
            return $this->render('home/index.html.twig', [
                'offres' => $offres,
                'categories' => $categories,
            ]);
        }

        // Vérifiez si une candidature existe déjà pour cet utilisateur et cette offre
        $existingCandidature = $entityManager->getRepository(Candidature::class)->findOneBy([
            'candidat' => $candidat,
            'offreEmploi' => $offre,
        ]);
        // dd($offres);
        if ($existingCandidature) {
            $this->addFlash('error', 'Vous avez déjà postulé à cette offre.');
            return $this->render('home/index.html.twig', [
                'offres' => $offres,
                'categories' => $categories,
            ]);
        }

        if ($candidat && $offre) {
            $candidature = new Candidature();
            $candidature->setOffreEmploi($offre);
            $candidature->setCandidat($candidat);
            $candidature->setStatut('En attente');
            $candidature->setCreatedAt(new \DateTimeImmutable());
            $candidature->setUpdatedAt(new \DateTimeImmutable());

            $entityManager->persist($candidature);
            $entityManager->flush();

            $this->addFlash('success', 'Votre candidature a été soumise avec succès.');
        } else {
            $this->addFlash('error', 'Erreur lors de la soumission de votre candidature.');
        }
        

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'offres' => $offres,
        ]);
    }

    #[Route('/{id}', name: 'app_candidature_show', methods: ['GET'])]
    public function show(Candidature $candidature): Response
    {
        return $this->render('candidature/show.html.twig', [
            'candidature' => $candidature,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_candidature_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Candidature $candidature, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $entityManager->flush();

            return $this->redirectToRoute('app_candidature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidature/edit.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_candidature_delete', methods: ['POST'])]
    public function delete(Request $request, Candidature $candidature, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidature->getId(), $request->request->get('_token'))) {
            $entityManager->remove($candidature);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_candidature_index', [], Response::HTTP_SEE_OTHER);
    }
}