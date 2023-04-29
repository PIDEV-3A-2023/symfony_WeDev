<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReclamationRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_rec = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"la description est obligatoire")]
    private ?string $description_rec = null;

    #[ORM\Column]
    private ?int $etat_rec =null;

    #[ORM\ManyToOne(inversedBy: 'type')]
    private ?TypeRec $type = null;



    public function getId(): ?int
    {
        return $this->id;
    }
    public function getEtatRec(): ?int
    {
        return $this->etat_rec;
    }
    public function getDateRec(): ?\DateTimeInterface
    {
        return $this->date_rec;
    }

    public function setDateRec(\DateTimeInterface $date_rec): self
    {
        $this->date_rec = $date_rec;

        return $this;
    }

    public function getDescriptionRec(): ?string
    {
        return $this->description_rec;
    }

    public function setDescriptionRec(string $description_rec): self
    {
        $this->description_rec = $description_rec;

        return $this;
    }
    public function setEtatRec(int $etat_rec): self
    {
        $this->etat_rec = $etat_rec;

        return $this;
    }
   

    public function getType(): ?TypeRec
    {
        return $this->type;
    }

    public function setType(?TypeRec $type): self
    {
        $this->type = $type;

        return $this;
    }
  
  
}
