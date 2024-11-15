<?php

namespace App\Controller\Admin;

use App\Controller\CategoriesController;
use App\Controller\HomeController;
use App\Controller\SecureFormLoginController;
use App\Entity\Categories;
use App\Entity\Items;
use App\Entity\Loans;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CategoriesCrudController::class)->generateUrl());

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
            ->setTitle('My Loc Symfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-list');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-tags', Categories::class);
        yield MenuItem::linkToCrud('Items', 'fa fa-screwdriver-wrench', Items::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-user', Users::class);
        yield MenuItem::linkToCrud('Loans', 'fa fa-arrow-right-arrow-left', Loans::class);
        yield MenuItem::linkToUrl('Back to the website', 'fas fa-home', '/home');
        yield MenuItem::linkToLogout('Logout', 'fa fa-right-from-bracket', 'app_home');
            
    }
}
