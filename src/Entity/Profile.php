<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class Profile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sex;

    /**
     * @ORM\Column(type="text")
     */
    private $info;

    /**
     * @ORM\Column(type="date")
     */
    private $dateBirthday;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="profile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Picture::class, mappedBy="profile", cascade={"persist", "remove"})
     */
    private $picture;

    /**
     * @ORM\OneToOne(targetEntity=Preference::class, mappedBy="profile")
     */
    private $preference;

    /**
     * @ORM\OneToMany(targetEntity=Reaction::class, mappedBy="userLiked", orphanRemoval=true)
     */
    private $reactionsLiked;

    /**
     * @ORM\OneToMany(targetEntity=Reaction::class, mappedBy="sendTo", orphanRemoval=true)
     */
    private $reactionsSendTo;


    public function __construct()
    {
        $this->reactionsLiked = new ArrayCollection();
        $this->reactionsSendTo = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSex(): ?bool
    {
        return $this->sex;
    }

    public function setSex(bool $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(string $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getDateBirthday(): ?\DateTimeInterface
    {
        return $this->dateBirthday;
    }

    public function setDateBirthday(\DateTimeInterface $dateBirthday): self
    {
        $this->dateBirthday = $dateBirthday;

        return $this;
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

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    public function setPicture(Picture $picture): self
    {
        // set the owning side of the relation if necessary
        if ($picture->getProfile() !== $this) {
            $picture->setProfile($this);
        }

        $this->picture = $picture;

        return $this;
    }

    public function getPreference(): ?Preference
    {
        return $this->preference;
    }

    public function setPreference(Preference $preference): self
    {
        // set the owning side of the relation if necessary
        if ($preference->getProfile() !== $this) {
            $preference->setProfile($this);
        }

        $this->preference = $preference;

        return $this;
    }

    /**
     * @return Collection|Reaction[]
     */
    public function getReactionsLiked(): Collection
    {
        return $this->reactionsLiked;
    }

    public function addReactionsLiked(Reaction $reaction): self
    {
        if (!$this->reactionsLiked->contains($reaction)) {
            $this->reactionsLiked[] = $reaction;
            $reaction->setUserLiked($this);
        }

        return $this;
    }

    public function removeReactionsLiked(Reaction $reaction): self
    {
        if ($this->reactionsLiked->removeElement($reaction)) {
            // set the owning side to null (unless already changed)
            if ($reaction->getUserLiked() === $this) {
                $reaction->setUserLiked(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reaction[]
     */
    public function getReactionsSendTo(): Collection
    {
        return $this->reactionsSendTo;
    }

    public function addReactionsSendTo(Reaction $reaction): self
    {
        if (!$this->reactionsSendTo->contains($reaction)) {
            $this->reactionsSendTo[] = $reaction;
            $reaction->setSendTo($this);
        }

        return $this;
    }

    public function removeReactionsSendTo(Reaction $reaction): self
    {
        if ($this->reactionsLiked->removeElement($reaction)) {
            // set the owning side to null (unless already changed)
            if ($reaction->getSendTo() === $this) {
                $reaction->setSendTo(null);
            }
        }

        return $this;
    }
}
