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
use App\Entity\Fichiers;
use App\Services\CandidateCompletionCalculator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(
        CandidatRepository $candidatRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        MailerInterface $mailer,
        CandidateCompletionCalculator $completionCalculator,
       
    ): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

      
        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

       
    
        

        $candidat = $candidatRepository->findOneBy(['user' => $user->getId()]);
        if ($candidat === null) {
            $candidat = new Candidat();
            $candidat->setUser($user);
            $candidat->setUpdatedAt(new \DateTimeImmutable());
        }

        if ($candidat->getFichiers() === null) {
            $candidat->setFichiers(new Fichiers());
        }

        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          
            if ($candidat->getCreatedAt() === null) {
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

            $email = $form->get('user')->get('email')->getData();
            $newPassword = $form->get('user')->get('newPassword')->getData();
            // dd($email, $newPassword);
            if ($email || $newPassword) {
                if ($email && $newPassword) {
                    if ($user->getEmail() !== $email) {
                        $this->addFlash('danger', 'The email you entered does not match the email associated with your account.');
                    } else {
                        $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                        $user->setPassword($hashedPassword);
                        try {
                            $mail = (new TemplatedEmail())
                                ->from('support@luxury-services.com')
                                ->to($user->getEmail())
                                ->subject('Change of password')
                                ->htmlTemplate('emails/change-password.html.twig');         
            
                            $mailer->send($mail);
                            $this->addFlash('successpassword', 'Your password has been changed successfully!');
                        } catch (\Exception $e) {
                            $this->addFlash('danger', 'An error occurred while sending the message : ' . $e->getMessage());
                        }
                    }
                } else {
                    $this->addFlash('danger', 'Email and password must be filled together to change password.');
                }
            }
            

            $entityManager->persist($candidat);
            $entityManager->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès.');
        }

        $completionRate = $completionCalculator->calculateCompletion($candidat);

        return $this->render('profil/profile.html.twig', [
            'form' => $form->createView(),
            'completionRate' => $completionRate,
            
        ]);
    }


    // #[Route('/profil/delete', name: 'app_profil_delete', methods: ['POST'])]
    // public function deleteAccount(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $user = $this->getUser();

    //     if ($user) {
    //         $entityManager->remove($user);
    //         $entityManager->flush();

    //         $this->addFlash('success', 'Your account has been deleted successfully.');

    //         // Déconnecter l'utilisateur après la suppression du compte
    //         $this->container->get('security.token_storage')->setToken(null);
    //         $request->getSession()->invalidate();
    //     }

    //     return $this->redirectToRoute('app_register');
    // }
}




