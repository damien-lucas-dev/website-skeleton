<?php


namespace App\Service;


use DateTime;

class SortieService
{
     const CREEE    = 1;
     const OUVERTE  = 2;
     const CLOTUREE = 3;
     const EN_COURS = 4;
     const PASSEE   = 5;
     const ANNULEE  = 6;

    function isEditable($sortie, $participant): bool
    {
        $isOld = in_array($sortie->getEtat()->getId(), [self::EN_COURS, self::PASSEE, self::ANNULEE]);
        $isNotOwned = $sortie->getOrganisateur() != $participant;
        return !$isOld && !$isNotOwned;
    }

    function setEtat($sortie, $status, $repository): void
    {
        if ($status === self::CREEE || $status === self::ANNULEE) {
            $sortie->setEtat($repository->find($status));
        } else {
            $beginning = $sortie->getDateHeureDebut()->getTimestamp();
            $ending = $beginning + ($sortie->getDuree() * 1000 * 60);
            $closing = $sortie->getDateLimiteInscription()->getTimestamp();
            $actual = (new DateTime())->getTimestamp();
            if ($ending < $actual) { $sortie->setEtat($repository->find(self::PASSEE)); }
            else if ($beginning < $actual && $ending > $actual) { $sortie->setEtat($repository->find(self::EN_COURS)); }
            else if ($closing < $actual) { $sortie->setEtat($repository->find(self::CLOTUREE)); }
            else { $sortie->setEtat($repository->find(self::OUVERTE)); }
        }
    }
}