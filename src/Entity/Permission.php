<?php

namespace App\Entity;

use App\Repository\PermissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
class Permission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPermission = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionPermission = null;

    #[ORM\ManyToOne(inversedBy: 'permissions')]
    private ?Module $Module = null;

    #[ORM\ManyToMany(targetEntity: Role::class, mappedBy: 'Permissions')]
    private Collection $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPermission(): ?string
    {
        return $this->nomPermission;
    }

    public function setNomPermission(string $nomPermission): self
    {
        $this->nomPermission = $nomPermission;

        return $this;
    }

    public function getDescriptionPermission(): ?string
    {
        return $this->descriptionPermission;
    }

    public function setDescriptionPermission(string $descriptionPermission): self
    {
        $this->descriptionPermission = $descriptionPermission;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->Module;
    }

    public function setModule(?Module $Module): self
    {
        $this->Module = $Module;

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            $role->addPermission($this);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->removeElement($role)) {
            $role->removePermission($this);
        }

        return $this;
    }
}
