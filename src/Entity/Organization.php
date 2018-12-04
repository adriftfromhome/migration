<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrganizationRepository")
 */
class Organization
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", length=36)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="organization")
     */
    private $masterUserId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="organization", orphanRemoval=true)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Department", mappedBy="organization", orphanRemoval=true)
     */
    private $departments;

    public function __construct()
    {
        $this->masterUserId = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->departments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getMasterUserId(): Collection
    {
        return $this->masterUserId;
    }

    public function addMasterUserId(User $masterUserId): self
    {
        if (!$this->masterUserId->contains($masterUserId)) {
            $this->masterUserId[] = $masterUserId;
            $masterUserId->setOrganization($this);
        }

        return $this;
    }

    public function removeMasterUserId(User $masterUserId): self
    {
        if ($this->masterUserId->contains($masterUserId)) {
            $this->masterUserId->removeElement($masterUserId);
            // set the owning side to null (unless already changed)
            if ($masterUserId->getOrganization() === $this) {
                $masterUserId->setOrganization(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setOrganization($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getOrganization() === $this) {
                $user->setOrganization(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Department[]
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): self
    {
        if (!$this->departments->contains($department)) {
            $this->departments[] = $department;
            $department->setOrganization($this);
        }

        return $this;
    }

    public function removeDepartment(Department $department): self
    {
        if ($this->departments->contains($department)) {
            $this->departments->removeElement($department);
            // set the owning side to null (unless already changed)
            if ($department->getOrganization() === $this) {
                $department->setOrganization(null);
            }
        }

        return $this;
    }
}
