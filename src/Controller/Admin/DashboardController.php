<?php

namespace App\Controller\Admin;

use App\Entity\Arome;
use App\Entity\Cepage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->
            setController(AromeCrudController::class)
            ->generateUrl();
        return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Inovin Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Aller sur le site', 'fa fa-undo', 'app_home');

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Arôme');

        yield MenuItem::submenu('Actions', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Ajouter un arôme', 'fas fa-plus-circle', Arome::class)->setAction(crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des arômes', 'fas fa-list', Arome::class)]);

        yield MenuItem::section('Cépage');

        yield MenuItem::submenu('Actions', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Ajouter un cépage', 'fas fa-plus-circle', Cepage::class)->setAction(crud::PAGE_NEW),
            MenuItem::linkToCrud('liste des cépages', 'fas fa-list', Cepage::class)]);

// yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
