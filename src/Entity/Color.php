<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use EntityTrait;

#[ORM\Entity(repositoryClass: ColorRepository::class)]
class Color
{
    use TimestampableEntity, EntityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'color')]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: Gout::class, mappedBy: 'color')]
    private Collection $gouts;
/*
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->gouts = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     *
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addColor($this);
        }

        return $this;
    }
*/
    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeColor($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Gout>
     */
    public function getGouts(): Collection
    {
        return $this->gouts;
    }

    public function addGout(Gout $gout): static
    {
        if (!$this->gouts->contains($gout)) {
            $this->gouts->add($gout);
            $gout->addColor($this);
        }

        return $this;
    }

    public function removeGout(Gout $gout): static
    {
        if ($this->gouts->removeElement($gout)) {
            $gout->removeColor($this);
        }

        return $this;
    }
}
