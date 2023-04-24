<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Velo
 *
 * @ORM\Table(name="velo", indexes={@ORM\Index(name="id_categorie", columns={"id_categorie"}), @ORM\Index(name="id_station", columns={"id_station"})})
 * @ORM\Entity
 */
class Velo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_velo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVelo;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=20, nullable=false)
     *  @Assert\NotBlank(message="Le champ 'titre' est obligatoire")
     */
    private $titre;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     *  @Assert\NotBlank(message="Le champ 'prix' est obligatoire")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=0, nullable=false)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="qte", type="integer", nullable=false)
     * * @Assert\NotBlank(message="Le champ 'Nom' est obligatoire")
     */
    private $qte;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="id_categorie")
     * })
     */
    private $idCategorie;

    /**
     * @var \Station
     *
     * @ORM\ManyToOne(targetEntity="Station")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_station", referencedColumnName="id_station")
     * })
     */
    private $idStation;

    public function getIdVelo(): ?int
    {
        return $this->idVelo;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getIdCategorie(): ?Categorie
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(?Categorie $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function getIdStation(): ?Station
    {
        return $this->idStation;
    }

    public function setIdStation(?Station $idStation): self
    {
        $this->idStation = $idStation;

        return $this;
    }


}
