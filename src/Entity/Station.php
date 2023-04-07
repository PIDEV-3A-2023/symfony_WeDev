<?php

namespace App\Entity;
use repository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\StationRepository;


#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $idStation = null;

    #[ORM\Column(type: 'string', length: 30)]
    private string $nomStation;

    #[ORM\Column(type: 'string', length: 30)]
    private string $localisationStation;

    #[ORM\Column(type: 'integer')]
    private int $veloStation;

    // Constructor, getters, and setters
    // ...

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
