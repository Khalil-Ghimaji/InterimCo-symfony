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
    private ?employes $id_employe = null;

    #[ORM\ManyToOne(inversedBy: 'competenceemployes')]
    private ?competences $id_competence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEmploye(): ?employes
    {
        return $this->id_employe;
    }

    public function setIdEmploye(?employes $id_employe): static
    {
        $this->id_employe = $id_employe;

        return $this;
    }

    public function getIdCompetence(): ?competences
    {
        return $this->id_competence;
    }

    public function setIdCompetence(?competences $id_competence): static
    {
        $this->id_competence = $id_competence;

        return $this;
    }
}
