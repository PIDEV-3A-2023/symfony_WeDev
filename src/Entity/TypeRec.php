<?php

namespace App\Entity;

use App\Repository\TypeRecRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TypeRecRepository::class)]
class TypeRec
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"le nom est obligatoire")]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Reclamation::class)]
    private Collection $reclamations;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Reclamation::class)]
    private Collection $type;

    public function __construct()
    {
        $this->reclamations = new ArrayCollection();
        $this->type = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom; // replace 'name' with the actual property you want to display
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

    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations->add($reclamation);
            $reclamation->setType($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getType() === $this) {
                $reclamation->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reclamation>
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(Reclamation $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type->add($type);
            $type->setType($this);
        }

        return $this;
    }

    public function removeType(Reclamation $type): self
    {
        if ($this->type->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getType() === $this) {
                $type->setType(null);
            }
        }

        return $this;
    }

   
    
 
}
