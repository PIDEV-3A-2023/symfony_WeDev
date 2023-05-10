<?php

namespace App\Entity;
use Doctrine\DBAL\Types\Types;
use repository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReclamationRepository;
use Symfony\Component\Serializer\Annotation\Groups;//ta3 el json

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
#[ORM\Table(name: "reclamation")]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_rec", type: "integer")]
    #[Groups("reclamations")]
    private ?int $idRec = null;

    #[ORM\Column(name: "date_rec", type: "date", nullable: false)]
    #[Groups("reclamations")]
    private ?\DateTimeInterface $dateRec = null;

    #[ORM\Column(name: "description_rec", type: "string", length: 255, nullable: true)]
    #[Groups("reclamations")]
    private ?string $descriptionRec = "j'ai un probléme";

    #[ORM\Column(name: "image", type: "string", length: 30)]
    #[Groups("reclamations")]
    private string $image ="en cours";

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "IdUser", referencedColumnName: "IdUser")]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: TypeRec::class)]
    #[ORM\JoinColumn(name: "id_type", referencedColumnName: "id_type")]
    #[Groups("reclamations")]
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
