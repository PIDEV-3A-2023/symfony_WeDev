<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_categorie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_categorie", type="string", length=30, nullable=false)
     */
    private $nomCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_categorie", type="string", length=30, nullable=false)
     */
    private $descCategorie;

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
