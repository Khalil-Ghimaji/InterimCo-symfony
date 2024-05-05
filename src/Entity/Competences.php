<?php

namespace App\Entity;

use App\Repository\CompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetencesRepository::class)]
class Competences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $competence = null;

    #[ORM\Column]
    private ?int $niveau_competence = null;

    #[ORM\Column]
    private ?float $prix_estime = null;



    /**
     * @var Collection<int, Prestations>
     */
    #[ORM\OneToMany(targetEntity: Prestations::class, mappedBy: 'competence')]
    private Collection $prestations;

    /**
     * @var Collection<int, employes>
     */
    #[ORM\ManyToMany(targetEntity: employes::class, inversedBy: 'competences')]
    private Collection $employe;

    public function __construct()
    {
        $this->prestations = new ArrayCollection();
        $this->employe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompetence(): ?string
    {
        return $this->competence;
    }

    public function setCompetence(string $competence): static
    {
        $this->competence = $competence;

        return $this;
    }

    public function getNiveauCompetence(): ?int
    {
        return $this->niveau_competence;
    }

    public function setNiveauCompetence(int $niveau_competence): static
    {
        $this->niveau_competence = $niveau_competence;

        return $this;
    }

    public function getPrixEstime(): ?float
    {
        return $this->prix_estime;
    }

    public function setPrixEstime(float $prix_estime): static
    {
        $this->prix_estime = $prix_estime;

        return $this;
    }



    /**
     * @return Collection<int, Prestations>
     */
    public function getPrestations(): Collection
    {
        return $this->prestations;
    }

    public function addPrestation(Prestations $prestation): static
    {
        if (!$this->prestations->contains($prestation)) {
            $this->prestations->add($prestation);
            $prestation->setIdCompetence($this);
        }

        return $this;
    }

    public function removePrestation(Prestations $prestation): static
    {
        if ($this->prestations->removeElement($prestation)) {
            // set the owning side to null (unless already changed)
            if ($prestation->getIdCompetence() === $this) {
                $prestation->setIdCompetence(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, employes>
     */
    public function getEmploye(): Collection
    {
        return $this->employe;
    }

    public function addEmploye(employes $employe): static
    {
        if (!$this->employe->contains($employe)) {
            $this->employe->add($employe);
        }

        return $this;
    }

    public function removeEmploye(employes $employe): static
    {
        $this->employe->removeElement($employe);

        return $this;
    }
}
