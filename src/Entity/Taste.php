<?php

namespace App\Entity;

use App\Repository\TasteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: TasteRepository::class)]
class Taste
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nameTaste = null;

    #[ORM\ManyToMany(targetEntity: TastingSheet::class, mappedBy: 'taste')]
    private Collection $tastingSheets;

    public function __construct()
    {
        $this->tastingSheets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTaste(): ?string
    {
        return $this->nameTaste;
    }

    public function setNameTaste(?string $nameTaste): static
    {
        $this->nameTaste = $nameTaste;

        return $this;
    }

    /**
     * @return Collection<int, TastingSheet>
     */
    public function getTastingSheets(): Collection
    {
        return $this->tastingSheets;
    }

    public function addTastingSheet(TastingSheet $tastingSheet): static
    {
        if (!$this->tastingSheets->contains($tastingSheet)) {
            $this->tastingSheets->add($tastingSheet);
            $tastingSheet->addTaste($this);
        }

        return $this;
    }

    public function removeTastingSheet(TastingSheet $tastingSheet): static
    {
        if ($this->tastingSheets->removeElement($tastingSheet)) {
            $tastingSheet->removeTaste($this);
        }

        return $this;
    }
}
