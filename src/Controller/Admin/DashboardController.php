<?php

namespace App\Controller\Admin;

use App\Entity\Librairie;
use App\Entity\Livre;
use App\Entity\Amateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(AmateurCrudController::class)->generateUrl();
        $url = $routeBuilder->setController(LibrairieCrudController::class)->generateUrl();
        $url = $routeBuilder->setController(LivreCrudController::class)->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administrateur');
            
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Amateurs', 'fas fa-list', Amateur::class);
        yield MenuItem::linkToCrud('Librairies', 'fas fa-list', Librairie::class);
        yield MenuItem::linkToCrud('Livres', 'fas fa-list', Livre::class);
    }
}
