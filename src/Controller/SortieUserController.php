<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Service\SortieService;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author D⩑⩋⫶⫕⩀
 * Class SortieUserController
 * name : sortied (d because of the author's name 👾)
 * @Route("/sortie/dams")
 */
class SortieUserController extends AbstractController
{
    private $jsonResponse;

    public function __construct(JsonResponse $jsonResponse)
    {
        $this->$jsonResponse = $jsonResponse;
    }

    /**
     * @Route("/", name="sortied")
     */
    public function index(): Response
    {

        return $this->render('sortie_dams/index.html.twig', [
            'controller_name' => 'SortieUserController',
        ]);
    }

    /**
     * @Route("/afficher", name="sortied_afficher")
     */
    public function afficher(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $sortieRepos = $em->getRepository(Sortie::class);
        $listeSorties = $sortieRepos->findAll();

        return $this->render('sortie_dams/afficher.html.twig', [
            'listeSorties' => $listeSorties
        ]);
    }

    /**
     * @Route("/afficher/{id}", name="sortied_details")
     */
    public function details(int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $sortieRepos = $em->getRepository(Sortie::class);
        $sortie = $sortieRepos->find($id);

        return $this->render('sortie_dams/details.html.twig', [
            'sortie' => $sortie,
            'participants' => $sortie->getParticipants()
        ]);
    }

    /**
     * @Route("/creer", name="sortied_creer")
     */
    public function creer(Request $request, SortieService $service): Response
    {
        $CREEE      = 1;
        $OUVERTE    = 2;
        $CLOTUREE   = 3;
        $EN_COURS   = 4;
        $PASSEE     = 5;
        $ANNULEE    = 6;

        // On prépare la nouvelle sortie et le formulaire
        $sortie = new Sortie();
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        // On fixe notamment son etat à créée :
        $entityManager = $this->getDoctrine()->getManager();
        $sortie->setEtat($entityManager->getRepository('App:Etat')->find($CREEE));
        $sortie->setOrga($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form);

            // c'est ici qu'on inscrit une nouvelle sortie. Il y a quelques vérifications à faire
            // comme vérifier si il reste des places disponibles par exemple

            $sortie->setEtat($entityManager->getRepository('App:Etat')->find($OUVERTE));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success', 'Ajouté !');
            return $this->redirectToRoute('sortied_afficher');
        }

        return $this->render('sortie_dams/creer.html.twig', [
            'form' => $form->createView(),
            'sortie' => $sortie
        ]);
    }

    /**
     * @Route("/getplaces", name="sortied_getplaces")
     */
    public function getplaces(Request $request): Response
    {
        $idVille = $request->get('ville');
        $lieuRepos = $this->getDoctrine()->getRepository('App:Lieu');
        $lieuxDeLaVille = $lieuRepos->findBy([
            'ville' => $idVille
        ]);

        $response = new Response();
        $response->setContent(json_encode([
            'data' => json_encode($lieuxDeLaVille)
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/subscribe/{id}", name="sortied_subscribe")
     */
    public function subscribe(int $id): Response
    {
        $sortie = $this->getDoctrine()->getManager()
                            ->getRepository(Sortie::class)->find($id);
        $nbPlacesRestantes = $sortie->getNbInscriptionsMax() - count($sortie->getParticipants());

        /// TODO: Mettre en place les vérifications de dates et autres !
        /// TODO: Ne pas hésiter à aller voir les autres codes ! https://github.com/ENI-SortirPointCom/SortirPointCom/

        if ($nbPlacesRestantes > 0) {
            $sortie->addParticipant($this->getUser());
            dump($this->getUser());
            dump($sortie->getParticipants());
            $nbPlacesRestantes = $sortie->getNbInscriptionsMax() - count($sortie->getParticipants());
            $this->addFlash('success', 'Inscrit !');
        }

        return $this->render('sortie_dams/subscribe.html.twig', [
            'sortie' => $sortie,
            'user' => $this->getUser(),
            'nbPlacesRestantes' => $nbPlacesRestantes
        ]);
    }
}
