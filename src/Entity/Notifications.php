<?php

namespace App\Entity;

use App\Repository\NotificationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationsRepository::class)]
class Notifications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?contrats $id_contrat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdContrat(): ?contrats
    {
        return $this->id_contrat;
    }

    public function setIdContrat(?contrats $id_contrat): static
    {
        $this->id_contrat = $id_contrat;

        return $this;
    }
}
