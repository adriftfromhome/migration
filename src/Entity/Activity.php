<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityRepository")
 */
class Activity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $masterUserId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $visibilty;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $recurring;

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

    public function getMasterUserId(): ?User
    {
        return $this->masterUserId;
    }

    public function setMasterUserId(?User $masterUserId): self
    {
        $this->masterUserId = $masterUserId;

        return $this;
    }

    public function getVisibilty(): ?string
    {
        return $this->visibilty;
    }

    public function setVisibilty(string $visibilty): self
    {
        $this->visibilty = $visibilty;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getRecurring(): ?string
    {
        return $this->recurring;
    }

    public function setRecurring(string $recurring): self
    {
        $this->recurring = $recurring;

        return $this;
    }
}
