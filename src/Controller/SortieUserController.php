<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Service\SortieService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * @author D⩑⩋⫶⫕⩀
 * Class SortieUserController
 * name : sortied (d because of the author's name 👾)
 * @Route("/sortie/dams")
 */
class SortieUserController extends AbstractController
{
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
    public function creer(Request $request, SortieService $service, EntityManagerInterface $em): Response
    {
        // On prépare la nouvelle sortie et le formulaire
        $sortie = new Sortie();
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        // On fixe notamment son etat à créée :
        $entityManager = $this->getDoctrine()->getManager();
        $sortie->setEtat($entityManager->getRepository('App:Etat')->find(SortieService::CREEE));

        if ($form->isSubmitted() && $form->isValid()) {
            // c'est ici qu'on inscrit une nouvelle sortie. Il y a quelques vérifications à faire
            // comme vérifier si il reste des places disponibles par exemple

            $sortie->setOrga($this->getUser());
            $sortie->setLieu($this->getEntitiesFromIds($form, $em));
            $sortie->setEtat($entityManager->getRepository('App:Etat')->find(SortieService::OUVERTE));

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
    public function getplaces(Request $request, JsonResponse $jsonResponse, EntityManagerInterface $em): Response
    {
        $idVille = $request->get('ville');
        $lieuRepos = $this->getDoctrine()->getRepository('App:Lieu');
        $lieuxDeLaVille = $lieuRepos->findBy([
            'ville' => $idVille
        ]);

        $query = $em->createQuery(
            'SELECT l
                  FROM App\Entity\Lieu l
                  WHERE l.id = ' . $idVille);
        $lieuxDeLaVille = $query->getArrayResult();

        return new JsonResponse($lieuxDeLaVille);
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

        if ($nbPlacesRestantes > 0) {
            if (! $sortie->getParticipants()->contains($this->getUser())) {
                if ($sortie->getDateLimiteInscription() < new \DateTime()) {
                    $ok = 'ok';
                    dump($ok);
                    $sortie->addParticipant($this->getUser());
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($sortie);
                    $em->flush();
                    $nbPlacesRestantes = $sortie->getNbInscriptionsMax() - count($sortie->getParticipants());
                    $this->addFlash('success', 'Inscrit !');
                }
                else {
                    $this->addFlash('error', 'Date limite d\'inscription dépassée');
                }
            }
            else {
                $this->addFlash('error', 'Vous êtes déjà inscrit à cette sortie !');
            }
        }
        else {
            $this->addFlash('error', 'Plus de place disponible !');
        }

        return $this->render('sortie_dams/subscribe.html.twig', [
            'sortie' => $sortie,
            'user' => $this->getUser(),
            'nbPlacesRestantes' => $nbPlacesRestantes
        ]);
    }

    /**
     * @Route("/cancel/{id}", name="sortied_ask_cancel")
     */
    public function askCancel(int $id): Response
    {
        return $this->render('sortie_dams/cancel.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/cancel/yes/{id}", name="sortied_cancel")
     */
    public function cancel(int $id, EntityManagerInterface $em): Response
    {
        $sortie = $em->getRepository('App:Sortie')->find($id);

        if ($sortie->getOrga() == $this->getUser()) {
            switch ($sortie->getEtat()->getId()) {
                case SortieService::CREEE:
                case SortieService::OUVERTE:
                    $sortie->setEtat($em->getRepository('App:Etat')->find(SortieService::ANNULEE));
                    $em->persist($sortie);
                    $em->flush();
                    $this->addFlash('success', 'Sortie annulée');
                    break;
                case SortieService::CLOTUREE:
                case SortieService::EN_COURS:
                case SortieService::PASSEE:
                case SortieService::ANNULEE:
                default:
                    $this->addFlash('error', 'Impossible d\'annuler une sortie qui ne soit plus ouverte à l\'inscription');
            }
        }
        else {
            $this->addFlash('error', 'Impossible d\'annuler une sortie dont vous n\'êtes pas l\'organisateur');
        }

        return $this->redirectToRoute('sortied_afficher');
    }

    /**
     * @Route("/cancel/subscription/{id}" name="sortied_cancel_subscription")
     */
    public function cancelSubscription(int $id, EntityManagerInterface $em): Response
    {
        $sortie = $em->getRepository('App:Sortie')->find($id);
        if ($sortie->getParticipants()->contains($this->getUser())) {
            if ($sortie->getEtat()->getId() <= SortieService::CLOTUREE) {
                $sortie->removeParticipant($this->getUser());
                $em->persist($sortie);
                $em->flush();
                $this->addFlash("success", "Participation annulée !");
            } else {
                $this->addFlash("error", "Il est trop tard pour se désinscrire");
            }
        } else {
            $this->addFlash("error", "Vous n'êtes déjà pas inscris à cette sortie !");
        }

        return $this->redirectToRoute("sortied_afficher");
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @param EntityManagerInterface $em
     */
    public function getEntitiesFromIds(\Symfony\Component\Form\FormInterface $form, EntityManagerInterface $em)
    {
        $idLieu = $form->getData()->getLieu();
        return $em->createQuery('SELECT s FROM App\Entity\Sortie s WHERE s.id = ' . $idLieu)->getResult();
    }
}
