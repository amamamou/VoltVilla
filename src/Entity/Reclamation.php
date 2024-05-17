<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateReclamation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $CodeClt = null;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $ReferencePd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReclamation(): ?\DateTimeInterface
    {
        return $this->DateReclamation;
    }

    public function setDateReclamation(\DateTimeInterface $DateReclamation): static
    {
        $this->DateReclamation = $DateReclamation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

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

    public function getReferencePd(): ?Produit
    {
        return $this->ReferencePd;
    }

    public function setReferencePd(?Produit $ReferencePd): static
    {
        $this->ReferencePd = $ReferencePd;

        return $this;
    }
}
