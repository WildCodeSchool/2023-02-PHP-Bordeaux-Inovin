<?php

namespace App\Entity;

use App\Repository\GoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GoutRepository::class)]
class Gout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Color::class, inversedBy: 'gouts')]
    private Collection $color;

    #[ORM\ManyToOne(inversedBy: 'gouts')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Arome::class, inversedBy: 'gouts')]
    private Collection $arome;

    #[ORM\ManyToMany(targetEntity: Region::class, inversedBy: 'gouts')]
    private Collection $region;

    public function __construct()
    {
        $this->color = new ArrayCollection();
        $this->arome = new ArrayCollection();
        $this->region = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Color>
     */
    public function getColor(): Collection
    {
        return $this->color;
    }

    public function addColor(Color $color): static
    {
        if (!$this->color->contains($color)) {
            $this->color->add($color);
        }

        return $this;
    }

    public function removeColor(Color $color): static
    {
        $this->color->removeElement($color);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Arome>
     */
    public function getArome(): Collection
    {
        return $this->arome;
    }

    public function addArome(Arome $arome): static
    {
        if (!$this->arome->contains($arome)) {
            $this->arome->add($arome);
        }

        return $this;
    }

    public function removeArome(Arome $arome): static
    {
        $this->arome->removeElement($arome);

        return $this;
    }

    /**
     * @return Collection<int, Region>
     */
    public function getRegion(): Collection
    {
        return $this->region;
    }

    public function addRegion(Region $region): static
    {
        if (!$this->region->contains($region)) {
            $this->region->add($region);
        }

        return $this;
    }

    public function removeRegion(Region $region): static
    {
        $this->region->removeElement($region);

        return $this;
    }
}
