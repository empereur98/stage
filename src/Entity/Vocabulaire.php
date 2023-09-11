<?php

namespace App\Entity;

use App\Repository\VocabulaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VocabulaireRepository::class)]
class Vocabulaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $mot = null;

    #[ORM\Column(length: 255)]
    private ?string $traduction = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $audio = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $exemple = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $niveau_difficulte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMot(): ?string
    {
        return $this->mot;
    }

    public function setMot(string $mot): static
    {
        $this->mot = $mot;

        return $this;
    }

    public function getTraduction(): ?string
    {
        return $this->traduction;
    }

    public function setTraduction(string $traduction): static
    {
        $this->traduction = $traduction;

        return $this;
    }

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(?string $audio): static
    {
        $this->audio = $audio;

        return $this;
    }

    public function getExemple(): ?array
    {
        return $this->exemple;
    }

    public function setExemple(?array $exemple): static
    {
        $this->exemple = $exemple;

        return $this;
    }

    public function getNiveauDifficulte(): ?array
    {
        return $this->niveau_difficulte;
    }

    public function setNiveauDifficulte(?array $niveau_difficulte): static
    {
        $this->niveau_difficulte = $niveau_difficulte;

        return $this;
    }
}
