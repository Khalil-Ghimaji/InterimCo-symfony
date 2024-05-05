<?php

namespace App\Entity;

use App\Repository\EmployeprestationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeprestationRepository::class)]
class Employeprestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'employeprestations')]
    private ?Employes $id_employe = null;

    #[ORM\ManyToOne(inversedBy: 'employeprestations')]
    private ?Prestations $id_prestation = null;

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

    public function getIdPrestation(): ?prestations
    {
        return $this->id_prestation;
    }

    public function setIdPrestation(?prestations $id_prestation): static
    {
        $this->id_prestation = $id_prestation;

        return $this;
    }
}
