<?php

namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
class Intervention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateInterv = null;

    #[ORM\ManyToOne(inversedBy: 'interventions')]
    private ?User $CodeClt = null;

    #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'interventions')]
    private Collection $ReferencePd;

    #[ORM\ManyToOne(inversedBy: 'interventions')]
    private ?Technecien $CodeTech = null;

    public function __construct()
    {
        $this->ReferencePd = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInterv(): ?\DateTimeInterface
    {
        return $this->DateInterv;
    }

    public function setDateInterv(\DateTimeInterface $DateInterv): static
    {
        $this->DateInterv = $DateInterv;

        return $this;
    }

    public function getCodeClt(): ?User
    {
        return $this->CodeClt;
    }

    public function setCodeClt(?User $CodeClt): static
    {
        $this->CodeClt = $CodeClt;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getReferencePd(): Collection
    {
        return $this->ReferencePd;
    }

    public function addReferencePd(Produit $referencePd): static
    {
        if (!$this->ReferencePd->contains($referencePd)) {
            $this->ReferencePd->add($referencePd);
        }

        return $this;
    }

    public function removeReferencePd(Produit $referencePd): static
    {
        $this->ReferencePd->removeElement($referencePd);

        return $this;
    }

    public function getCodeTech(): ?Technecien
    {
        return $this->CodeTech;
    }

    public function setCodeTech(?Technecien $CodeTech): static
    {
        $this->CodeTech = $CodeTech;

        return $this;
    }
}
