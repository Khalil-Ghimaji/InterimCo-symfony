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

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_deb_finale = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin_finale = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix_final = null;

    #[ORM\ManyToOne(inversedBy: 'prestations')]
    private ?Competences $competence = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'prestations')]
    private ?Contrats $contrat = null;

    #[ORM\ManyToMany(targetEntity: Employes::class, mappedBy: 'prestations')]
    private Collection $employes;

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
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getDateDebFinale(): ?\DateTimeInterface
    {
        return $this->date_deb_finale;
    }

    public function setDateDebFinale(?\DateTimeInterface $date_deb_finale): static
    {
        $this->date_deb_finale = $date_deb_finale;

        return $this;
    }

    public function getDateFinFinale(): ?\DateTimeInterface
    {
        return $this->date_fin_finale;
    }

    public function setDateFinFinale(?\DateTimeInterface $date_fin_finale): static
    {
        $this->date_fin_finale = $date_fin_finale;

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

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPrixFinal(): ?float
    {
        return $this->prix_final;
    }

    public function setPrixFinal(?float $prix_final): static
    {
        $this->prix_final = $prix_final;

        return $this;
    }

    public function getCompetence(): ?competences
    {
        return $this->competence;
    }

    public function setCompetence(?competences $competence): static
    {
        $this->competence = $competence;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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
}
