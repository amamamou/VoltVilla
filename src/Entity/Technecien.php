<?php
namespace App\Entity;

use App\Repository\TechnecienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnecienRepository::class)]
class Technecien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\Column(type: 'boolean')]
    private bool $available = true; // New attribute for availability

    #[ORM\OneToMany(mappedBy: 'CodeTech', targetEntity: Intervention::class)]
    private Collection $interventions;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    public function __construct()
    {
        $this->interventions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function isAvailable(): bool // Getter for availability
    {
        return $this->available;
    }

    public function setAvailable(bool $available): static // Setter for availability
    {
        $this->available = $available;

        return $this;
    }

    /**
     * @return Collection<int, Intervention>
     */
    public function getInterventions(): Collection
    {
        return $this->interventions;
    }

    public function addIntervention(Intervention $intervention): static
    {
        if (!$this->interventions->contains($intervention)) {
            $this->interventions->add($intervention);
            $intervention->setCodeTech($this);
        }

        // Update availability status
        $this->setAvailable(false);

        return $this;
    }

    public function removeIntervention(Intervention $intervention): static
    {
        if ($this->interventions->removeElement($intervention)) {
            // set the owning side to null (unless already changed)
            if ($intervention->getCodeTech() === $this) {
                $intervention->setCodeTech(null);
            }
        }

        // Check if there are any remaining interventions
        $remainingInterventions = $this->getInterventions()->count();
        if ($remainingInterventions === 0) {
            // If no interventions remaining, set availability to true
            $this->setAvailable(true);
        }

        return $this;
    }
    
    public function __toString()
    {
        return $this->Nom; // Assuming 'name' is a property of Technecien entity
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }
}