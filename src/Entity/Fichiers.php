<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[Vich\Uploadable]
class Fichiers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $chemin_photo = null;

    #[Vich\UploadableField(mapping: 'candidat_photo', fileNameProperty: 'chemin_photo')]
    private ?File $photoFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $chemin_cv = null;

    #[Vich\UploadableField(mapping: 'candidat_cv', fileNameProperty: 'chemin_cv')]
    #[Assert\File(maxSize: '5M', mimeTypes: ['application/pdf'], mimeTypesMessage: 'Please upload a valid PDF file')]
    private ?File $cvFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $chemin_passeport = null;

    #[Vich\UploadableField(mapping: 'candidat_passeport', fileNameProperty: 'chemin_passeport')]
    private ?File $passeportFile = null;

    #[ORM\OneToOne(mappedBy: 'fichiers', cascade: ['persist', 'remove'])]
    private ?Candidat $candidat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCheminPhoto(): ?string
    {
        return $this->chemin_photo;
    }

    public function setCheminPhoto(?string $chemin_photo): self
    {
        $this->chemin_photo = $chemin_photo;
        return $this;
    }

    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    public function setPhotoFile(?File $photoFile = null): void
    {
        $this->photoFile = $photoFile;
    }

    public function getCheminCv(): ?string
    {
        return $this->chemin_cv;
    }

    public function setCheminCv(?string $chemin_cv): self
    {
        $this->chemin_cv = $chemin_cv;
        return $this;
    }

    public function getCvFile(): ?File
    {
        return $this->cvFile;
    }

    public function setCvFile(?File $cvFile = null): void
    {
        $this->cvFile = $cvFile;
    }

    public function getCheminPasseport(): ?string
    {
        return $this->chemin_passeport;
    }

    public function setCheminPasseport(?string $chemin_passeport): self
    {
        $this->chemin_passeport = $chemin_passeport;
        return $this;
    }

    public function getPasseportFile(): ?File
    {
        return $this->passeportFile;
    }

    public function setPasseportFile(?File $passeportFile = null): void
    {
        $this->passeportFile = $passeportFile;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;
        return $this;
    }
}