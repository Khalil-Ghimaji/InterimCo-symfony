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
     * @var Collection<int, Competenceemploye>
     */
    #[ORM\OneToMany(targetEntity: Competenceemploye::class, mappedBy: 'id_competence')]
    private Collection $competenceemployes;

    /**
     * @var Collection<int, Prestations>
     */
    #[ORM\OneToMany(targetEntity: Prestations::class, mappedBy: 'id_competence')]
    private Collection $prestations;

    public function __construct()
    {
        $this->competenceemployes = new ArrayCollection();
        $this->prestations = new ArrayCollection();
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
     * @return Collection<int, Competenceemploye>
     */
    public function getCompetenceemployes(): Collection
    {
        return $this->competenceemployes;
    }

    public function addCompetenceemploye(Competenceemploye $competenceemploye): static
    {
        if (!$this->competenceemployes->contains($competenceemploye)) {
            $this->competenceemployes->add($competenceemploye);
            $competenceemploye->setIdCompetence($this);
        }

        return $this;
    }

    public function removeCompetenceemploye(Competenceemploye $competenceemploye): static
    {
        if ($this->competenceemployes->removeElement($competenceemploye)) {
            // set the owning side to null (unless already changed)
            if ($competenceemploye->getIdCompetence() === $this) {
                $competenceemploye->setIdCompetence(null);
            }
        }

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
}
