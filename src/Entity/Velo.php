<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VeloRepository;
use Symfony\Component\Serializer\Annotation\Groups;//ta3 el json


#[ORM\Table(name: 'velo')]
#[ORM\Entity(repositoryClass: VeloRepository::class)]
class Velo
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer', name: 'id_velo')]
    #[Groups("velos")]
    private $idVelo;

    #[ORM\Column(type: 'string', length: 20, nullable: false, name: 'titre')]
    #[Groups("velos")]
    private $titre = null;

    #[ORM\Column(type: 'float', precision: 10, scale: 0, nullable: false, name: 'prix')]
    #[Groups("velos")]
    private $prix = null;

    #[ORM\Column(type: 'string', length: 255, nullable: false, name: 'image')]
    #[Groups("velos")]
    private $image = null;

    #[ORM\Column(type: 'integer', nullable: false, name: 'qte')]
    #[Groups("velos")]
    private $qte = null;

    #[ORM\ManyToOne(targetEntity: Station::class)]
    #[ORM\JoinColumn(name: 'id_station', referencedColumnName: 'id_station')]
    #[Groups("velos")]
    private $idStation;

    #[ORM\ManyToOne(targetEntity: Categorie::class)]
    #[ORM\JoinColumn(name: 'id_categorie', referencedColumnName: 'id_categorie')]
    #[Groups("velos")]
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
    public function getCategorie()
{
    return $this->idCategorie;
}
}
