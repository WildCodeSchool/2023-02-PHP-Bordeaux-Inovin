<?php

namespace App\Entity;

use App\Repository\CepageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CepageRepository::class)]
class Cepage
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nameCepage = null;

    #[ORM\OneToMany(mappedBy: 'cepage', targetEntity: Wine::class)]
    private Collection $wines;

    public function __construct()
    {
        $this->wines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCepage(): ?string
    {
        return $this->nameCepage;
    }

    public function setNameCepage(string $nameCepage): static
    {
        $this->nameCepage = $nameCepage;

        return $this;
    }

    /**
     * @return Collection<int, Wine>
     */
    public function getWines(): Collection
    {
        return $this->wines;
    }

    public function addWine(Wine $wine): static
    {
        if (!$this->wines->contains($wine)) {
            $this->wines->add($wine);
            $wine->setCepage($this);
        }

        return $this;
    }

    public function removeWine(Wine $wine): static
    {
        if ($this->wines->removeElement($wine)) {
            // set the owning side to null (unless already changed)
            if ($wine->getCepage() === $this) {
                $wine->setCepage(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getNameCepage();
    }
}
