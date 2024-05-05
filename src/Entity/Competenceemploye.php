<?php

namespace App\Entity;

use App\Repository\CompetenceemployeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetenceemployeRepository::class)]
class Competenceemploye
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'competenceemployes')]
    private ?employes $employe = null;

    #[ORM\ManyToOne(inversedBy: 'competenceemployes')]
    private ?competences $competence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmploye(): ?employes
    {
        return $this->employe;
    }

    public function setEmploye(?employes $employe): static
    {
        $this->employe = $employe;

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
}
