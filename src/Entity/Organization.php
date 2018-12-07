<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

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
     * @JMS\Groups({"public"})
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
     * @ORM\OneToMany(targetEntity="App\Entity\UserInvite", mappedBy="organization")
     */
    private $userInvites;

    public function __construct()
    {
        $this->masterUserId = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->userInvites = new ArrayCollection();
    }

    public function getId(): ?string
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
     * @return Collection|UserInvite[]
     */
    public function getUserInvites(): Collection
    {
        return $this->userInvites;
    }

    public function addUserInvite(UserInvite $userInvite): self
    {
        if (!$this->userInvites->contains($userInvite)) {
            $this->userInvites[] = $userInvite;
            $userInvite->setOrganization($this);
        }

        return $this;
    }

    public function removeUserInvite(UserInvite $userInvite): self
    {
        if ($this->userInvites->contains($userInvite)) {
            $this->userInvites->removeElement($userInvite);
            // set the owning side to null (unless already changed)
            if ($userInvite->getOrganization() === $this) {
                $userInvite->setOrganization(null);
            }
        }

        return $this;
    }
}
