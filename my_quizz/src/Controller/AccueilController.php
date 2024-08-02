<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Historique;
use App\Entity\Question;
use App\Entity\Reponse;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_cat')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Categorie::class);
        $categorieList = $repository->findAllCategorie();
        return $this->render('categorie.html.twig', [
            'categories' => $categorieList,
        ]);
    }

    #[Route('/cat/{id}', name: 'app_qst')]
    public function Question(EntityManagerInterface $entityManager, $id)
    {
        $repository = $entityManager->getRepository(Question::class);
        $questionList = $repository->findQuestion($id);

        $reponseList = $entityManager->getRepository(Reponse::class)->findReponse($questionList);

        shuffle($reponseList);

        $id_categorie = $questionList[0]->getIdCategorie();

        return $this->render('question.html.twig', [
            'questions' => $questionList,
            'reponses' => $reponseList,
            'id_cat' => $id_categorie,
        ]);
    }

    #[Route('/cat/{id}/reponse', name: 'app_reponse')]
    public function Reponse(EntityManagerInterface $entityManager, $id)
    {
        $repository = $entityManager->getRepository(Question::class);
        $questionList = $repository->findQuestion($id);

        $reponseList = $entityManager->getRepository(Reponse::class)->findReponse($questionList);

        $count = 0;

        foreach ($_POST as $post) {
            $truerep = $entityManager->getRepository(Reponse::class)->findOneReponse(intval($post));
            if ($truerep[0]->getReponseExpected() == 1) {
                $count++;
            }
        }


        if (!is_null($this->getUser())) {
            $historique = new Historique();
            $historique->setIdUser($this->getUser()->getId());
            $historique->setNbBonneRep($count);
            $historique->setIdCategorie($questionList[0]->getIdCategorie());
            $historique->setNbQuestion(count($questionList));
            $entityManager->persist($historique);
            $entityManager->flush();
        } else {
            if (!isset($_SESSION["historique"])) {
                session_start();
                $_SESSION["historique"] = [];
            }

            $temp = [];

            $temp['nbBonneRep'] = $count;
            $temp['idCategorie'] = $questionList[0]->getIdCategorie();
            $temp['nbQuestion'] = count($questionList);

            array_push($_SESSION["historique"], $temp);
            // dd($_SESSION["historique"]);
        }

        return $this->render('reponse.html.twig', [
            'reponses_post' => $_POST,
            'questions' => $questionList,
            'reponses' => $reponseList,
            'nbRep' => $count,
        ]);
    }

    #[Route('/historique', name: 'app_historique')]
    public function Historique(EntityManagerInterface $entityManager)
    {
        
        session_start();
        if (!isset($_SESSION["historique"])) {
            return $this->render('historique.html.twig');
        }

        // session_start();
        $session = $_SESSION["historique"];

        if (!is_null($this->getUser())) {

            $repository = $entityManager->getRepository(Historique::class);
            $historiqueList = $repository->getHistorique();

            $id = [];

            foreach($historiqueList as $hist){
                array_push($id, $hist->getIdCategorie());
            }

            $repository = $entityManager->getRepository(Categorie::class);
            $categorieList = $repository->findOneCategorie($id);

            return $this->render('historique.html.twig', [
                'historique' => $historiqueList,
                'categorieList' => $categorieList,
            ]);
        } else {
            $id = [];
            // dd($_SESSION['historique'][0]['idCategorie']);
            foreach($_SESSION['historique'] as $hist){
                // dd($hist['idCategorie']);
                array_push($id, $hist['idCategorie']);
            }

            $repository = $entityManager->getRepository(Categorie::class);
            $session = $repository->findOneCategorie($id);

            return $this->render('historique.html.twig', [
                'session' => $session,
                'session_items' => $_SESSION['historique'],
            ]);
        }
    }


    // public function Reponse(EntityManagerInterface $entityManager, array $id)
    // {
    //     $repository = $entityManager->getRepository(Question::class);
    //     $questionList = $repository->findQuestion($id);



    //     print_r($reponseList);

    //     return $this->render('reponse.html.twig', [
    //         'reponses' => $reponseList,
    //     ]);
    // }
}
