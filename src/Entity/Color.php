<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;


#[ORM\Entity(repositoryClass: ColorRepository::class)]
class Color
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $nameColor = null;

    #[ORM\ManyToMany(targetEntity: Gout::class, mappedBy: 'color')]
    private Collection $gouts;

    public function __construct()
    {
        $this->gouts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameColor(): ?string
    {
        return $this->nameColor;
    }

    public function setNameColor(string $nameColor): self
    {
        $this->nameColor = $nameColor;

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
