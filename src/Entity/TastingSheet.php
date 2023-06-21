<?php

namespace App\Entity;

use App\Repository\TastingSheetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: TastingSheetRepository::class)]
class TastingSheet
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $clarity = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $intensity = null;

    #[ORM\ManyToMany(targetEntity: Taste::class, inversedBy: 'tastingSheets')]
    private Collection $taste;

    #[ORM\ManyToMany(targetEntity: Smell::class, inversedBy: 'tastingSheets')]
    private Collection $smell;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Comment $comment = null;

    #[ORM\ManyToOne(inversedBy: 'tastingSheets')]
    private ?Wine $wine = null;

    #[ORM\ManyToOne(inversedBy: 'tastingSheets')]
    private ?Workshop $workshop = null;

    public function __construct()
    {
        $this->taste = new ArrayCollection();
        $this->smell = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getClarity(): ?string
    {
        return $this->clarity;
    }

    public function setClarity(?string $clarity): static
    {
        $this->clarity = $clarity;

        return $this;
    }

    public function getIntensity(): ?string
    {
        return $this->intensity;
    }

    public function setIntensity(?string $intensity): static
    {
        $this->intensity = $intensity;

        return $this;
    }

    /**
     * @return Collection<int, Taste>
     */
    public function getTaste(): Collection
    {
        return $this->taste;
    }

    public function addTaste(Taste $taste): static
    {
        if (!$this->taste->contains($taste)) {
            $this->taste->add($taste);
        }

        return $this;
    }

    public function removeTaste(Taste $taste): static
    {
        $this->taste->removeElement($taste);

        return $this;
    }

    /**
     * @return Collection<int, Smell>
     */
    public function getSmell(): Collection
    {
        return $this->smell;
    }

    public function addSmell(Smell $smell): static
    {
        if (!$this->smell->contains($smell)) {
            $this->smell->add($smell);
        }

        return $this;
    }

    public function removeSmell(Smell $smell): static
    {
        $this->smell->removeElement($smell);

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getWine(): ?Wine
    {
        return $this->wine;
    }

    public function setWine(?Wine $wine): static
    {
        $this->wine = $wine;

        return $this;
    }

    public function getWorkshop(): ?Workshop
    {
        return $this->workshop;
    }

    public function setWorkshop(?Workshop $workshop): static
    {
        $this->workshop = $workshop;

        return $this;
    }
}
