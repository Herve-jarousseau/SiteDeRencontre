<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReactionRepository::class)
 */
class Reaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $reciprocal;

    /**
     * @ORM\ManyToOne(targetEntity=Profile::class, inversedBy="reactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userLiked;

    /**
     * @ORM\ManyToOne(targetEntity=Profile::class, inversedBy="reactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sendTo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getReciprocal(): ?bool
    {
        return $this->reciprocal;
    }

    public function setReciprocal(?bool $reciprocal): self
    {
        $this->reciprocal = $reciprocal;

        return $this;
    }

    public function getUserLiked(): ?Profile
    {
        return $this->userLiked;
    }

    public function setUserLiked(?Profile $userLiked): self
    {
        $this->userLiked = $userLiked;

        return $this;
    }

    public function getSendTo(): ?Profile
    {
        return $this->sendTo;
    }

    public function setSendTo(?Profile $sendTo): self
    {
        $this->sendTo = $sendTo;

        return $this;
    }
}
