<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Station
 *
 * @ORM\Table(name="station")
 * @ORM\Entity
 */
class Station
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_station", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStation;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_station", type="string", length=30, nullable=false)
     */
    private $nomStation;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation_station", type="string", length=30, nullable=false)
     */
    private $localisationStation;

    /**
     * @var int
     *
     * @ORM\Column(name="velo_station", type="integer", nullable=false)
     */
    private $veloStation;

    public function getIdStation(): ?int
    {
        return $this->idStation;
    }

    public function getNomStation(): ?string
    {
        return $this->nomStation;
    }

    public function setNomStation(string $nomStation): self
    {
        $this->nomStation = $nomStation;

        return $this;
    }

    public function getLocalisationStation(): ?string
    {
        return $this->localisationStation;
    }

    public function setLocalisationStation(string $localisationStation): self
    {
        $this->localisationStation = $localisationStation;

        return $this;
    }

    public function getVeloStation(): ?int
    {
        return $this->veloStation;
    }

    public function setVeloStation(int $veloStation): self
    {
        $this->veloStation = $veloStation;

        return $this;
    }


}
