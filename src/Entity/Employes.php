<?php

namespace App\Entity;

use App\Repository\EmployesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployesRepository::class)]
class Employes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;



    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?int $numero_telephone = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_inscription = null;

    /**
     * @var Collection<int, Employeprestation>
     */
    #[ORM\OneToMany(targetEntity: Employeprestation::class, mappedBy: 'id_employe')]
    private Collection $employeprestations;

    /**
     * @var Collection<int, Competenceemploye>
     */
    #[ORM\OneToMany(targetEntity: Competenceemploye::class, mappedBy: 'id_employe')]
    private Collection $competenceemployes;

    public function __construct()
    {
        $this->employeprestations = new ArrayCollection();
        $this->competenceemployes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }



    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNumeroTelephone(): ?int
    {
        return $this->numero_telephone;
    }

    public function setNumeroTelephone(int $numero_telephone): static
    {
        $this->numero_telephone = $numero_telephone;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(?\DateTimeInterface $date_inscription): static
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    /**
     * @return Collection<int, Employeprestation>
     */
    public function getEmployeprestations(): Collection
    {
        return $this->employeprestations;
    }

    public function addEmployeprestation(Employeprestation $employeprestation): static
    {
        if (!$this->employeprestations->contains($employeprestation)) {
            $this->employeprestations->add($employeprestation);
            $employeprestation->setIdEmploye($this);
        }

        return $this;
    }

    public function removeEmployeprestation(Employeprestation $employeprestation): static
    {
        if ($this->employeprestations->removeElement($employeprestation)) {
            // set the owning side to null (unless already changed)
            if ($employeprestation->getIdEmploye() === $this) {
                $employeprestation->setIdEmploye(null);
            }
        }

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
            $competenceemploye->setIdEmploye($this);
        }

        return $this;
    }

    public function removeCompetenceemploye(Competenceemploye $competenceemploye): static
    {
        if ($this->competenceemployes->removeElement($competenceemploye)) {
            // set the owning side to null (unless already changed)
            if ($competenceemploye->getIdEmploye() === $this) {
                $competenceemploye->setIdEmploye(null);
            }
        }

        return $this;
    }
}
