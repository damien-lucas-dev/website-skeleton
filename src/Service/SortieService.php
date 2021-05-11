<?php


namespace App\Service;


use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class SortieService
{
     const CREEE    = 1;
     const OUVERTE  = 2;
     const CLOTUREE = 3;
     const EN_COURS = 4;
     const PASSEE   = 5;
     const ANNULEE  = 6;

     private $sortieRep;
     private $etatsRep;
    private $em;

    public function __construct(EntityManagerInterface $em)
     {
         $this->em = $em;
         $this->sortieRep = $em->getRepository('App:Sortie');
         $this->etatsRep = $em->getRepository('App:Etat');
     }

    function isEditable($sortie, $participant): bool
    {
        $isOld = in_array($sortie->getEtat()->getId(), [self::EN_COURS, self::PASSEE, self::ANNULEE]);
        $isNotOwned = $sortie->getOrganisateur() != $participant;
        return !$isOld && !$isNotOwned;
    }

    function checkAndChangeSortiesStates()
    {
        $listeSortiesATraiter = $this->sortieRep->findSortiesNotPassedOrCancelled();

        foreach ($listeSortiesATraiter as $sortie) {
            // Vérification de la cloture des inscriptions
            $this->verifClotureInscriptions($sortie, $this->em);
            // Vérification du nombre d'inscrits
            $this->verifNbParticipants($sortie, $this->em);
            // Vérification EN_COURS
            $this->verifEnCours($sortie, $this->em);
            // Historisation si > 1 mois
            $this->historisationSortiesFiniesDepuisPlusDUnMois($sortie, $this->em);
        }

    }

    /**
     * @param $sortie
     * @param EntityManagerInterface $em
     */
    public function verifClotureInscriptions($sortie, EntityManagerInterface $em): void
    {
        $clotureInscriptions = $sortie->getDateLimiteInscription()->getTimestamp();
        $now = (new \DateTime)->getTimestamp();
        if ($clotureInscriptions <= $now) {
            $sortie->setEtat($this->etatsRep->find(self::CLOTUREE));
            $em->persist($sortie);
            $em->flush();
        }
    }

    /**
     * @param $sortie
     * @param EntityManagerInterface $em
     */
    public function verifNbParticipants($sortie, EntityManagerInterface $em): void
    {
        if (count($sortie->getParticipants()) >= $sortie->getNbInscriptionsMax()) {
            $sortie->setEtat($this->etatsRep->find(self::CLOTUREE));
            $em->persist($sortie);
            $em->flush();
        }
        else if (($sortie->getEtat()->getId() == self::CLOTUREE) && count($sortie->getParticipants()) < $sortie->getNbInscriptionsMax())
        {
            $sortie->setEtat($this->etatsRep->find(self::OUVERTE));
            $em->persist($sortie);
            $em->flush();
        }
    }

    /**
     * @param $sortie
     * @param EntityManagerInterface $em
     */
    public function historisationSortiesFiniesDepuisPlusDUnMois($sortie, EntityManagerInterface $em): void
    {
        $debutSortie = $sortie->getDateHeureDebut()->getTimestamp();
        $finSortie = $debutSortie + ($sortie->getDuree() * 1000 * 60);
        $unMoisTimestamp = 60 * 60 * 24 * 30 * 1000;
        if ((new \DateTime)->getTimestamp() - $finSortie > $unMoisTimestamp) {
            $sortie->setEtat(self::PASSEE);
            $em->persist($sortie);
            $em->flush();
        }
    }

    /**
     * @param $sortie
     * @param EntityManagerInterface $em
     */
    public function verifEnCours($sortie, EntityManagerInterface $em): void
    {
        if ($sortie->getEtat()->getId() == self::CLOTUREE && ($sortie->getDateHeureDebut()->getTimestamp() > (new \DateTime)->getTimestamp())) {
            $sortie->setEtat($this->etatsRep->find(self::EN_COURS));
            $em->persist($sortie);
            $em->flush();
        }
    }
}