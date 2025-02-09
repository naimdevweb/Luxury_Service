<?php
namespace App\Entity;

use App\Repository\TypeContratRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeContratRepository::class)]
class TypeContrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, OffreEmploi>
     */
    #[ORM\OneToMany(targetEntity: OffreEmploi::class, mappedBy: 'typeContrat')]
    private Collection $offremploi;

    
    public function __construct()
    {
        $this->offremploi = new ArrayCollection();
        $this->offremploi = new ArrayCollection();
    }

    
   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom ?? '';
    }

    /**
     * @return Collection<int, OffreEmploi>
     */
    public function getOffremploi(): Collection
    {
        return $this->offremploi;
    }

    public function addOffremploi(OffreEmploi $offremploi): static
    {
        if (!$this->offremploi->contains($offremploi)) {
            $this->offremploi->add($offremploi);
            $offremploi->setTypeContrat($this);
        }

        return $this;
    }

    public function removeOffremploi(OffreEmploi $offremploi): static
    {
        if ($this->offremploi->removeElement($offremploi)) {
            // set the owning side to null (unless already changed)
            if ($offremploi->getTypeContrat() === $this) {
                $offremploi->setTypeContrat(null);
            }
        }

        return $this;
    }

   

   
    }
