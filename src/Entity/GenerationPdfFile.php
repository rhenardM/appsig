<?php

namespace App\Entity;

use App\Repository\GenerationPdfFileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenerationPdfFileRepository::class)]
class GenerationPdfFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $zoneExpediteur = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $zoneText = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(?\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getZoneExpediteur(): ?string
    {
        return $this->zoneExpediteur;
    }

    public function setZoneExpediteur(?string $zoneExpediteur): static
    {
        $this->zoneExpediteur = $zoneExpediteur;

        return $this;
    }

    public function getZoneText(): ?string
    {
        return $this->zoneText;
    }

    public function setZoneText(string $zoneText): static
    {
        $this->zoneText = $zoneText;

        return $this;
    }
}
