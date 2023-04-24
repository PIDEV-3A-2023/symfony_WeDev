<?php

namespace App\Entity;
use Doctrine\DBAL\Types\Types;
use repository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReclamationRepository;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
#[ORM\Table(name: "reclamation")]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_rec", type: "integer")]
    private ?int $idRec = null;

    #[ORM\Column(name: "date_rec", type: "date", nullable: true)]
    private ?\DateTimeInterface $dateRec = null;

    #[ORM\Column(name: "description_rec", type: "string", length: 255, nullable: true)]
    private ?string $descriptionRec = null;

    #[ORM\Column(name: "image", type: "string", length: 30)]
    private string $image;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "IdUser", referencedColumnName: "IdUser")]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: TypeRec::class)]
    #[ORM\JoinColumn(name: "id_type", referencedColumnName: "id_type")]
    private ?TypeRec $typeRec = null;

    public function getIdRec(): ?int
    {
        return $this->idRec;
    }

    public function getDateRec(): ?\DateTimeInterface
    {
        return $this->dateRec;
    }

    public function setDateRec(?\DateTimeInterface $dateRec): self
    {
        $this->dateRec = $dateRec;

        return $this;
    }

    public function getDescriptionRec(): ?string
    {
        return $this->descriptionRec;
    }

    public function setDescriptionRec(?string $descriptionRec): self
    {
        $this->descriptionRec = $descriptionRec;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTypeRec(): ?TypeRec
    {
        return $this->typeRec;
    }

    public function setTypeRec(?TypeRec $typeRec): self
    {
        $this->typeRec = $typeRec;

        return $this;
    }
}
