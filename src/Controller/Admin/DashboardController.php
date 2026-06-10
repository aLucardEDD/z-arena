<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

// Importation obligatoire du contrôleur CRUD !
use App\Controller\Admin\HeroTemplateCrudController; 
use App\Controller\Admin\EnnemiesTemplateCrudController;
use App\Controller\Admin\ItemTemplateCrudController; 
use App\Controller\Admin\SkillCrudController; 


#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(HeroTemplateCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Projet Spe');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        

        yield MenuItem::linkTo(HeroTemplateCrudController::class, 'Stats des Héros', 'fas fa-address-book');
        yield MenuItem::linkTo(EnnemiesTemplateCrudController::class, 'Stats des Ennemis', 'fas fa-ghost');
        yield MenuItem::linkTo(ItemTemplateCrudController::class, 'Catalogue Objets', 'fas fa-box');
        yield MenuItem::linkTo(SkillCrudController::class, 'Catalogue des compétences', 'fas fa-box');
    }
}