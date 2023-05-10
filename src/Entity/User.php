<?php

namespace App\Entity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;//ta3 el json


#[ORM\Table(name: 'user')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User  
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name: 'IdUser')]
    #[Groups("users")]
    private ?int $iduser= null;

    #[ORM\Column(type: 'string', length: 20, name: 'NomUser')]
    #[Groups("users")]
    private ?string $nomuser= null;

    #[ORM\Column(type: 'string', length: 30, name: 'PrenomUser')]
    #[Groups("users")]
    private ?string $prenomuser= null;

    #[ORM\Column(type: 'date', name: 'DateNaiss')]
    #[Groups("users")]
    private \DateTimeInterface $datenaiss;

    #[ORM\Column(type: 'string', length: 50, name: 'NumTel')]
    #[Groups("users")]
    private ?string $numtel= null;

    #[ORM\Column(type: 'string', length: 50, name: 'Email',unique: true)]
    #[Groups("users")]
    private ?string $email= null;

    #[ORM\Column(type: 'string', length: 30, name: 'Adresse')]
    #[Groups("users")]
    private ?string $adresse= null;

    #[ORM\Column(type: 'string', length: 1048, name: 'ImgUser')]
    #[Groups("users")]
    private ?string $imguser= null;

    #[ORM\Column]
    #[Groups("users")]
    private ?string $mdp ;


    #[ORM\Column]
    #[Groups("users")]
    private ?string $role ;


    #[ORM\Column(type: 'integer', name: 'EtatCompte')]
    #[Groups("users")]
    private ?int $etatcompte = 0;
/////////////////////////////////////////////////////
    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function getNomuser(): ?string
    {
        return $this->nomuser;
    }

    public function setNomuser(string $nomuser): self
    {
        $this->nomuser = $nomuser;

        return $this;
    }

    public function getPrenomuser(): ?string
    {
        return $this->prenomuser;
    }

    public function setPrenomuser(string $prenomuser): self
    {
        $this->prenomuser = $prenomuser;

        return $this;
    }

    public function getDatenaiss(): ?\DateTimeInterface
    {
        return $this->datenaiss;
    }

    public function setDatenaiss(\DateTimeInterface $datenaiss): self
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

    public function getNumtel(): ?string
    {
        return $this->numtel;
    }

    public function setNumtel(string $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->mdp;
    }
    public function setPassword(string $mdp): self
    {
        $this->mdp = $mdp;
    
        return $this;
    }
    

    public function getmdp(): string
    {
        return $this->mdp;
    }

    public function setmdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getImguser(): ?string
    {
        return $this->imguser;
    }

    public function setImguser(string $imguser): self
    {
        $this->imguser = $imguser;

        return $this;
    }

    public function getEtatcompte(): ?int
    {
        return $this->etatcompte;
    }

    public function setEtatcompte(int $etatcompte): self
    {
        $this->etatcompte = $etatcompte;

        return $this;
    }


    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function __toString()
    {
        return $this->nomuser;
    }
}
