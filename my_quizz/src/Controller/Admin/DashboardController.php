<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\User;
use App\Repository\QuestionRepository;

use App\Entity\Historique;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class DashboardController extends AbstractDashboardController
{
    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository, EntityManagerInterface $entityManager)
    {
        $this->questionRepository = $questionRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

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

        $DernierHistoriques = $this->entityManager->getRepository(Historique::class)->findLast(3);
        // dd($DernierHistoriques);
        $DernierComptes = $this->entityManager->getRepository(User::class)->findLast(3);

        return $this->render('admin/index.html.twig',[
            'StatHisto' => $DernierHistoriques,
            'StatUser' => $DernierComptes
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('My Quizz');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-dashboard');
        yield MenuItem::linkToCrud('Utilisateur', 'fa fa-users', User::class);
        yield MenuItem::linkToCrud('Categorie', 'fa fa-folder', Categorie::class);
        yield MenuItem::linkToCrud('Question', 'fa fa-question-circle', Question::class);
        yield MenuItem::linkToCrud('Reponse', 'fa fa-comments', Reponse::class);
        yield MenuItem::linkToRoute('Retour au site','fa-solid fa-circle-left','app_accueil');
    }
}
