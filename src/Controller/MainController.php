<?php

namespace App\Controller;

use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */
    public function home(SortieRepository $sortieRepository): Response
    {
        return $this->redirectToRoute('sortied_afficher');
        /*return $this->render('main/home.html.twig', [
            'controller_name' => 'MainController',
            'sorties' => $sortieRepository->findAll()
        ]);*/
    }
}
