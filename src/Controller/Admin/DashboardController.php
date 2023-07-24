<?php

namespace App\Controller\Admin;

use App\Entity\Arome;
use App\Entity\Cepage;
use App\Entity\Color;
use App\Entity\Gout;
use App\Entity\Region;
use App\Entity\Smell;
use App\Entity\Taste;
use App\Entity\User;
use App\Entity\Wine;
use App\Entity\Workshop;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }
    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebpackEncoreEntry('admin');
    }
    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->
            setController(UserCrudController::class)
            ->generateUrl();
        return $this->redirect($url);
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

        yield MenuItem::linkToCrud('liste des utilsateurs', 'fas fa-list', User::class);

        yield MenuItem::linkToCrud('liste des Goûts par utilisateur', 'fas fa-list', Gout::class);

        yield MenuItem::section('Ateliers');

        yield MenuItem::submenu('', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Ajouter un atelier', 'fas fa-plus-circle', Workshop::class)
                ->setAction(crud::PAGE_NEW),
            MenuItem::linkToCrud('liste des ateliers', 'fas fa-list', Workshop::class)]);

        yield MenuItem::section('Fiche de Goût client');

        yield MenuItem::submenu('Arômes', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Ajouter un arôme', 'fas fa-plus-circle', Arome::class)->setAction(crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des arômes', 'fas fa-list', Arome::class)]);

        yield MenuItem::submenu('Couleurs', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Ajouter une couleur', 'fas fa-plus-circle', Color::class)->setAction(crud::PAGE_NEW),
            MenuItem::linkToCrud('liste des couleurs', 'fas fa-list', Color::class)]);

        yield MenuItem::submenu('Régions', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Ajouter une régions', 'fas fa-plus-circle', Region::class)->setAction(crud::PAGE_NEW),
            MenuItem::linkToCrud('liste des régions', 'fas fa-list', Region::class)]);

        yield MenuItem::section('Fiche de dégustation');

        yield MenuItem::submenu('Arômes', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Ajouter un arôme', 'fas fa-plus-circle', Smell::class)->setAction(crud::PAGE_NEW),
            MenuItem::linkToCrud('liste des arômes', 'fas fa-list', Smell::class)]);

        yield MenuItem::submenu('Saveurs', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Ajouter une saveur', 'fas fa-plus-circle', Taste::class)->setAction(crud::PAGE_NEW),
            MenuItem::linkToCrud('liste des saveur', 'fas fa-list', Taste::class)]);

        yield MenuItem::section('Cépages');

        yield MenuItem::submenu('', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Ajouter un cépage', 'fas fa-plus-circle', Cepage::class)->setAction(crud::PAGE_NEW),
            MenuItem::linkToCrud('liste des cépages', 'fas fa-list', Cepage::class)]);

        yield MenuItem::section('Vin');

        yield MenuItem::submenu('', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Ajouter un vin', 'fas fa-plus-circle', Wine::class)
                ->setAction(crud::PAGE_NEW),
            MenuItem::linkToCrud('liste des Vin', 'fas fa-list', Wine::class)]);
    }
}
