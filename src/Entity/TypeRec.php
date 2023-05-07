<?php

namespace App\Entity;
use repository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeRecRepository;
use Symfony\Component\Serializer\Annotation\Groups;//ta3 el json

#[ORM\Entity(repositoryClass: TypeRecRepository::class)]
class TypeRec
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $idType = null;

    #[ORM\Column(type: 'string', length: 20)]
    #[Groups("reclamations")]
    private string $etatRec;

    // Constructor, getters, and setters
    // ...

    public function getIdType(): ?int
    {
        return $this->idType;
    }

    public function getEtatRec(): ?string
    {
        return $this->etatRec;
    }

    public function setEtatRec(string $etatRec): self
    {
        $this->etatRec = $etatRec;

        return $this;
    }
    public function __toString()
    {
        return $this->etatRec; // assuming that the Station entity has a 'name' property
    }
}
