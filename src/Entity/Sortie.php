<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SortieRepository::class)
 */
class Sortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max=255, maxMessage="{{ limit }} caractères max. pour le nom de la sortie")
     */
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual("today")
     */
    private $dateHeureDebut;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="date")
     */
    private $dateLimiteInscription;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbInscriptionsMax;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $infosSortie;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="sorties")
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="sorties")
     */
    private $campus;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, inversedBy="sorties")
     */
    private $participants;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="sortiesOrganisees")
     */
    private $orga;

    /**
     * @ORM\ManyToOne(targetEntity=Lieu::class, inversedBy="sorties")
     */
    private $lieu;

    /**
     * @ORM\OneToMany(targetEntity=Annulation::class, mappedBy="sortie", orphanRemoval=true)
     */
    private $annulations;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->annulations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->nbInscriptionsMax;
    }

    public function setNbInscriptionsMax(int $nbInscriptionsMax): self
    {
        $this->nbInscriptionsMax = $nbInscriptionsMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(UserInterface $participant): self
    {
        if (!$this->participants->contains($participant) && count($this->participants) < $this->nbInscriptionsMax) {
            $this->participants[] = $participant;
        }

        return $this;
    }

    public function removeParticipant(UserInterface $participant): self
    {
        $this->participants->removeElement($participant);

        return $this;
    }

    public function getOrga(): ?Utilisateur
    {
        return $this->orga;
    }

    public function setOrga(?UserInterface $orga): self
    {
        $this->orga = $orga;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return Collection|Annulation[]
     */
    public function getAnnulations(): Collection
    {
        return $this->annulations;
    }

    public function addAnnulation(Annulation $annulation): self
    {
        if (!$this->annulations->contains($annulation)) {
            $this->annulations[] = $annulation;
            $annulation->setSortie($this);
        }

        return $this;
    }

    public function removeAnnulation(Annulation $annulation): self
    {
        if ($this->annulations->removeElement($annulation)) {
            // set the owning side to null (unless already changed)
            if ($annulation->getSortie() === $this) {
                $annulation->setSortie(null);
            }
        }

        return $this;
    }
}
