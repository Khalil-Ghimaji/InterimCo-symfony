<?php

namespace App\Entity;

use App\Repository\PrestationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestationsRepository::class)]
class Prestations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFinFinale = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebFinale = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?float $prixFinal = null;

    #[ORM\ManyToOne]
    private ?competences $competence = null;

    /**
     * @var Collection<int, Employes>
     */
    #[ORM\ManyToMany(targetEntity: Employes::class, mappedBy: 'prestations')]
    private Collection $employes;

    #[ORM\ManyToOne(inversedBy: 'prestations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?contrats $contrat = null;

    public function __construct()
    {
        $this->employes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDateFinFinale(): ?\DateTimeInterface
    {
        return $this->dateFinFinale;
    }

    public function setDateFinFinale(\DateTimeInterface $dateFinFinale): static
    {
        $this->dateFinFinale = $dateFinFinale;

        return $this;
    }

    public function getDateDebFinale(): ?\DateTimeInterface
    {
        return $this->dateDebFinale;
    }

    public function setDateDebFinale(\DateTimeInterface $dateDebFinale): static
    {
        $this->dateDebFinale = $dateDebFinale;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPrixFinal(): ?float
    {
        return $this->prixFinal;
    }

    public function setPrixFinal(float $prixFinal): static
    {
        $this->prixFinal = $prixFinal;

        return $this;
    }

    public function getcompetence(): ?competences
    {
        return $this->competence;
    }

    public function setcompetence(?competences $competence): static
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * @return Collection<int, Employes>
     */
    public function getEmployes(): Collection
    {
        return $this->employes;
    }

    public function addEmploye(Employes $employe): static
    {
        if (!$this->employes->contains($employe)) {
            $this->employes->add($employe);
            $employe->addPrestation($this);
        }

        return $this;
    }

    public function removeEmploye(Employes $employe): static
    {
        if ($this->employes->removeElement($employe)) {
            $employe->removePrestation($this);
        }

        return $this;
    }

    public function getContrat(): ?contrats
    {
        return $this->contrat;
    }

    public function setContrat(?contrats $contrat): static
    {
        $this->contrat = $contrat;

        return $this;
    }
}
