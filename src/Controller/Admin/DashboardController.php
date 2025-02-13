<?php
namespace App\Controller\Admin;

use App\Entity\Candidat;
use App\Entity\Candidature;
use App\Entity\Client;
use App\Entity\ExperienceProfessionel;
use App\Entity\Genre;
use App\Entity\OffreEmploi;
use App\Entity\TypeContrat;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
       
            return $this->render('admin/dashboard.html.twig');
       
    }
    

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LuxuryService');
    }

    public function configureMenuItems(): iterable
    {
         /**
         * @var User $user
         */
        $user = $this->getUser();
        $roles = $user->getRoles();

        if (in_array('ROLE_ADMIN', $roles)) {
            yield MenuItem::linkToDashboard('Dashboard', 'fa fa-tachometer-alt');
            yield MenuItem::section('Jobs');
            yield MenuItem::linkToCrud('OffreEmploi', 'fas fa-user-tie', OffreEmploi::class);
            yield MenuItem::section('Candidates');
            yield MenuItem::linkToCrud('Candidat', 'fas fa-user-tie', Candidat::class);
            yield MenuItem::linkToCrud('Candidature', 'fas fa-user-tie', Candidature::class);
            yield MenuItem::section('Recruters');
            yield MenuItem::linkToCrud('Client', 'fas fa-user-tie', Client::class);
            yield MenuItem::section('Job Offers');
            yield MenuItem::linkToCrud('TypeContrat', 'fas fa-user-tie', TypeContrat::class);
            yield MenuItem::linkToCrud('OffreEmploi', 'fas fa-user-tie', OffreEmploi::class);
            yield MenuItem::section('Candidates');
            yield MenuItem::linkToCrud('Genre', 'fas fa-venus-mars', Genre::class);
            yield MenuItem::linkToCrud('ExperienceProfessionel', 'fas fa-briefcase', ExperienceProfessionel::class);
            yield MenuItem::section('Recruters');
            yield MenuItem::linkToCrud('Recruters', 'fas fa-user-tie', User::class);
        } elseif (in_array('ROLE_RECRUTEUR', $roles)) {
            yield MenuItem::linkToDashboard('Dashboard', 'fa fa-tachometer-alt');
            yield MenuItem::section('Jobs');
            yield MenuItem::linkToCrud('OffreEmploi', 'fas fa-user-tie', OffreEmploi::class)
            ->setEntityId($user->getId());
            yield MenuItem::section('Candidates');
            yield MenuItem::linkToCrud('Candidature', 'fas fa-user-tie', Candidature::class);
            yield MenuItem::section('Recruters');
            yield MenuItem::linkToCrud('Client', 'fas fa-user-tie', Client::class);
        }
    }
}