<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LieuUserController extends AbstractController
{
    /**
     * @Route("/lieu/creer", name="lieu_user_create")
     */
    public function index(Request $request): Response
    {
        // On prépare le nouveau lieu et le formulaire :
        $lieu = new Lieu();
        $form = $this->createForm(LieuType::class, $lieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //TODO: Ajouter la validation !!
            //TODO: Ajouter l'extraction de l'adresse pour trouver la latitude longitude ! Surement via un service
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lieu);
            $entityManager->flush();

            $this->addFlash('success', 'Nouveau lieu ajouté !');
            return $this->redirectToRoute('sortied_creer', [
            ]);
        }


        return $this->render('lieu_user/creer.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
