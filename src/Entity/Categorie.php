<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRepository;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCategorie = null;

    #[ORM\Column(length: 30)]
    private ?string $nomCategorie = null;

    #[ORM\Column(length: 30)]
    private ?string $descCategorie = null;

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): self
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    public function getDescCategorie(): ?string
    {
        return $this->descCategorie;
    }

    public function setDescCategorie(string $descCategorie): self
    {
        $this->descCategorie = $descCategorie;

        return $this;
    }

}
