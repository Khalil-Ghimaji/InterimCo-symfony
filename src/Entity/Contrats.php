<?php

namespace App\Entity;

use App\Repository\ContratsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContratsRepository::class)]
class Contrats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_soumission = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_reponse = null;

    #[ORM\Column(length: 255)]
    private ?string $etat_contrat = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix_final = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Clients $client = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    private ?agentsdrh $agent_drh = null;

    #[ORM\OneToMany(targetEntity: Prestations::class, mappedBy: 'contrat')]
    private Collection $prestations;

    public function __construct()
    {
        $this->prestations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDateSoumission(): ?\DateTimeInterface
    {
        return $this->date_soumission;
    }

    public function setDateSoumission(?\DateTimeInterface $date_soumission): static
    {
        $this->date_soumission = $date_soumission;

        return $this;
    }

    public function getDateReponse(): ?\DateTimeInterface
    {
        return $this->date_reponse;
    }

    public function setDateReponse(?\DateTimeInterface $date_reponse): static
    {
        $this->date_reponse = $date_reponse;

        return $this;
    }

    public function getEtatContrat(): ?string
    {
        return $this->etat_contrat;
    }

    public function setEtatContrat(string $etat_contrat): static
    {
        $this->etat_contrat = $etat_contrat;

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

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(?Clients $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getAgentDrh(): ?agentsdrh
    {
        return $this->agent_drh;
    }

    public function setAgentDrh(?agentsdrh $agent_drh): static
    {
        $this->agent_drh = $agent_drh;

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
            $prestation->setContrat($this);
        }

        return $this;
    }

    public function removePrestation(Prestations $prestation): static
    {
        if ($this->prestations->removeElement($prestation)) {
            // set the owning side to null (unless already changed)
            if ($prestation->getContrat() === $this) {
                $prestation->setContrat(null);
            }
        }

        return $this;
    }
}
