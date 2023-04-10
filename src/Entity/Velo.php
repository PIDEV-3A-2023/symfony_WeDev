<?php

namespace App\Entity;
use repository;
use Doctrine\ORM\Mapping as ORM;
use App\repository\VeloRepository;

#[ORM\Table(name: 'velo')]
#[ORM\Entity(repositoryClass: VeloRepository::class)]
class Velo
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer', name: 'id_velo')]
    private $idVelo;

    #[ORM\Column(type: 'string', length: 20, nullable: false, name: 'titre')]
    private $titre;

    #[ORM\Column(type: 'float', precision: 10, scale: 0, nullable: false, name: 'prix')]
    private $prix;

    #[ORM\Column(type: 'string', length: 255, nullable: false, name: 'image')]
    private $image;

    #[ORM\Column(type: 'integer', nullable: false, name: 'qte')]
    private $qte;

    #[ORM\ManyToOne(targetEntity: Station::class)]
    #[ORM\JoinColumn(name: 'id_station', referencedColumnName: 'id_station')]
    private $idStation;

    #[ORM\ManyToOne(targetEntity: Categorie::class)]
    #[ORM\JoinColumn(name: 'id_categorie', referencedColumnName: 'id_categorie')]
    private $idCategorie;

    public function getIdVelo()
    {
        return $this->idVelo;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getQte()
    {
        return $this->qte;
    }

    public function setQte($qte)
    {
        $this->qte = $qte;
        return $this;
    }

    public function getIdStation()
    {
        return $this->idStation;
    }

    public function setIdStation($idStation)
    {
        $this->idStation = $idStation;
        return $this;
    }

    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie = $idCategorie;
        return $this;
    }
}
