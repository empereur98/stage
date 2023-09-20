<?php
namespace App\Entity;

use App\Repository\VocabulaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
#[ORM\Entity(repositoryClass: VocabulaireRepository::class)]
#[Vich\Uploadable]
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

    #[Vich\UploadableField(mapping: 'property_audio', fileNameProperty: 'filename')]
    private ?File $audioFile = null;

    #[ORM\Column(length:255,nullable: true)]
    private ?string $filename = null;

    #[ORM\Column(length:255, nullable: true)]
    private ?string $exemple = null;

    #[ORM\ManyToOne(inversedBy: 'vocabulaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cours $lesson = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMot(): ?string
    {
        return $this->mot;
    }

    #[ORM\Column]
    private ?\DateTimeImmutable $uppade_at = null;

    public function getFilename(): ?string{
        return $this->filename;
    }

    public function setFilename(?string $filename): static{
        $this->filename = $filename;
        return $this;
    }
    public function getAudioFile(): ?File{
        return $this->audioFile;
    }

    public function setAudiofile(?File $audioFile): static{
        $this->audioFile = $audioFile;
        if ($this->audioFile instanceof UploadedFile) {
            $this->uppade_at = new \DateTimeImmutable('now');
        }
        return $this;
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

    public function getExemple(): ?string
    {
        return $this->exemple;
    }

    public function setExemple(?string $exemple): static
    {
        $this->exemple = $exemple;

        return $this;
    }

    public function getLesson(): ?Cours
    {
        return $this->lesson;
    }

    public function setLesson(?Cours $lesson): static
    {
        $this->lesson = $lesson;

        return $this;
    }
}
