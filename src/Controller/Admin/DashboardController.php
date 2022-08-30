<?php

namespace App\Controller\Admin;

use App\Entity\ApiToken;
use App\Entity\CodeLanguage;
use App\Entity\SubmitType;
use App\Entity\Task;
use App\Entity\TaskSubmit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DashboardController extends AbstractDashboardController
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
        yield MenuItem::linkToDashboard('Admin', 'fa fa-home');
        yield MenuItem::linkToRoute('Tasks', 'fa fa-list-check', 'default');
        yield MenuItem::section('Task');
        yield MenuItem::linkToCrud('View tasks', 'fas fa-list', Task::class)->setAction("index");
        yield MenuItem::linkToCrud('Add task', 'fas fa-plus', Task::class)->setAction("new");
        yield MenuItem::section('Code Languages');
        yield MenuItem::linkToCrud('View languages', 'fas fa-list', CodeLanguage::class)->setAction("index");
        yield MenuItem::linkToCrud('Add language', 'fas fa-plus', CodeLanguage::class)->setAction("new");
        yield MenuItem::section('Submit Types');
        yield MenuItem::linkToCrud('View submit types', 'fas fa-list', SubmitType::class)->setAction("index");
        yield MenuItem::linkToCrud('Add submit type', 'fas fa-plus', SubmitType::class)->setAction("new");
        yield MenuItem::section('Task submits');
        yield MenuItem::linkToCrud('View task submits', 'fas fa-list', TaskSubmit::class)->setAction("index");
        yield MenuItem::section('Tokens');
        yield MenuItem::linkToCrud('View tokens', 'fas fa-list', ApiToken::class)->setAction("index");
    }
}
