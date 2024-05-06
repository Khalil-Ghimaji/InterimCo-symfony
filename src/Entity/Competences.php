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

    #[ORM\Column(length: 30)]
    private ?string $competence = null;

    #[ORM\Column]
    private ?int $niveauCompetence = null;

    #[ORM\Column]
    private ?float $prixEstime = null;

    /**
     * @var Collection<int, employes>
     */
    #[ORM\ManyToMany(targetEntity: employes::class, inversedBy: 'competences')]
    private Collection $employes;

    public function __construct()
    {
        $this->employes = new ArrayCollection();
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
        return $this->niveauCompetence;
    }

    public function setNiveauCompetence(int $niveauCompetence): static
    {
        $this->niveauCompetence = $niveauCompetence;

        return $this;
    }

    public function getPrixEstime(): ?float
    {
        return $this->prixEstime;
    }

    public function setPrixEstime(float $prixEstime): static
    {
        $this->prixEstime = $prixEstime;

        return $this;
    }

    /**
     * @return Collection<int, employes>
     */
    public function getEmployes(): Collection
    {
        return $this->employes;
    }

    public function addEmploye(employes $employe): static
    {
        if (!$this->employes->contains($employe)) {
            $this->employes->add($employe);
        }

        return $this;
    }

    public function removeEmploye(employes $employe): static
    {
        $this->employes->removeElement($employe);

        return $this;
    }
}
