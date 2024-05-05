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
    private ?Employes $employe = null;

    #[ORM\ManyToOne(inversedBy: 'employeprestations')]
    private ?Prestations $prestation = null;

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

    public function getPrestation(): ?prestations
    {
        return $this->prestation;
    }

    public function setPrestation(?prestations $prestation): static
    {
        $this->prestation = $prestation;

        return $this;
    }
}
