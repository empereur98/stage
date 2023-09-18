<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\NiveauEnum;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id=null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length:50)]
    #[NiveauEnum]
    private ?string $niveau = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $objectif = null;

    #[ORM\OneToMany(mappedBy: 'lesson', targetEntity: Vocabulaire::class)]
    private Collection $vocabulaires;

    #[ORM\ManyToOne(inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Langue $langue = null;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: Exercice::class, orphanRemoval: true)]
    private Collection $exercice;

    public function __construct()
    {
        $this->vocabulaires = new ArrayCollection();
        $this->exercice = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getObjectif(): ?string
    {
        return $this->objectif;
    }

    public function setObjectif(?string $objectif): static
    {
        $this->objectif = $objectif;

        return $this;
    }

    /**
     * @return Collection<int, Vocabulaire>
     */
    public function getVocabulaires(): Collection
    {
        return $this->vocabulaires;
    }

    public function addVocabulaire(Vocabulaire $vocabulaire): static
    {
        if (!$this->vocabulaires->contains($vocabulaire)) {
            $this->vocabulaires->add($vocabulaire);
            $vocabulaire->setLesson($this);
        }

        return $this;
    }

    public function removeVocabulaire(Vocabulaire $vocabulaire): static
    {
        if ($this->vocabulaires->removeElement($vocabulaire)) {
            // set the owning side to null (unless already changed)
            if ($vocabulaire->getLesson() === $this) {
                $vocabulaire->setLesson(null);
            }
        }

        return $this;
    }

    public function getLangue(): ?Langue
    {
        return $this->langue;
    }

    public function setLangue(?Langue $langue): static
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * @return Collection<int, Exercice>
     */
    public function getExercice(): Collection
    {
        return $this->exercice;
    }

    public function addExercice(Exercice $exercice): static
    {
        if (!$this->exercice->contains($exercice)) {
            $this->exercice->add($exercice);
            $exercice->setCours($this);
        }

        return $this;
    }

    public function removeExercice(Exercice $exercice): static
    {
        if ($this->exercice->removeElement($exercice)) {
            // set the owning side to null (unless already changed)
            if ($exercice->getCours() === $this) {
                $exercice->setCours(null);
            }
        }

        return $this;
    }
}
