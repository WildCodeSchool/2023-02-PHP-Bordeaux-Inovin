<?php

namespace App\Entity;

use App\Repository\AromeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: AromeRepository::class)]
class Arome
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nameArome = null;

    #[ORM\ManyToMany(targetEntity: Gout::class, mappedBy: 'arome')]
    private Collection $gouts;

    public function __construct()
    {
        $this->gouts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameArome(): ?string
    {
        return $this->nameArome;
    }

    public function setNameArome(string $nameArome): self
    {
        $this->nameArome = $nameArome;

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
            $gout->addArome($this);
        }

        return $this;
    }

    public function removeGout(Gout $gout): static
    {
        if ($this->gouts->removeElement($gout)) {
            $gout->removeArome($this);
        }

        return $this;
    }
}
