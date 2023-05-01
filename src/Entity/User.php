<?php

namespace App\Entity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Table(name: 'user')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name: 'IdUser')]
    private ?int $iduser= null;

    #[ORM\Column(type: 'string', length: 20, name: 'NomUser')]
    private ?string $nomuser= null;

    #[ORM\Column(type: 'string', length: 30, name: 'PrenomUser')]
    private ?string $prenomuser= null;

    #[ORM\Column(type: 'date', name: 'DateNaiss')]
    private \DateTimeInterface $datenaiss;

    #[ORM\Column(type: 'string', length: 50, name: 'NumTel')]
    private ?string $numtel= null;

    #[ORM\Column(type: 'string', length: 50, name: 'Email',unique: true)]
    private ?string $email= null;

    #[ORM\Column(type: 'string', length: 30, name: 'Adresse')]
    private ?string $adresse= null;

    #[ORM\Column(type: 'string', length: 1048, name: 'ImgUser')]
    private ?string $imguser= null;

    #[ORM\Column]
    private ?string $mdp ;


     /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];
    private array $role = [];

    #[ORM\Column(type: 'integer', name: 'EtatCompte')]
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
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles = array_merge($roles, ['ROLE_ADMIN', 'ROLE_CLIENT']);

        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
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


    public function getRole(): array
    {
        return $this->role;
    }

    public function setRole(array $role): self
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
