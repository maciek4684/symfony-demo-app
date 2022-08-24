<?php

namespace App\Controller\Admin;

use App\Entity\CodeLanguage;
use App\Entity\Task;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin panel');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Code Languages');
        yield MenuItem::linkToCrud('View languages', 'fas fa-list', CodeLanguage::class)->setAction("index");
        yield MenuItem::linkToCrud('Add language', 'fas fa-plus', CodeLanguage::class)->setAction("new");
        yield MenuItem::section('Task');
        yield MenuItem::linkToCrud('View tasks', 'fas fa-list', Task::class)->setAction("index");
        yield MenuItem::linkToCrud('Add task', 'fas fa-plus', Task::class)->setAction("new");
    }
}
