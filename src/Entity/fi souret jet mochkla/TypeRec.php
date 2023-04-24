<?php

namespace App\Entity;
use repository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeRecRepository;

#[ORM\Entity(repositoryClass: TypeRecRepository::class)]
class TypeRec
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $idType = null;

    #[ORM\Column(type: 'string', length: 20)]
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
}
