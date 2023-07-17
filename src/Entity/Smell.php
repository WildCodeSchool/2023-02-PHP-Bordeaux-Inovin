<?php

namespace App\Entity;

use App\Repository\SmellRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: SmellRepository::class)]
class Smell
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nameSmell = null;

    #[ORM\ManyToMany(targetEntity: TastingSheet::class, mappedBy: 'smell')]
    private Collection $tastingSheets;

    public function __construct()
    {
        $this->tastingSheets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameSmell(): ?string
    {
        return $this->nameSmell;
    }

    public function setNameSmell(?string $nameSmell): static
    {
        $this->nameSmell = $nameSmell;

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
            $tastingSheet->addSmell($this);
        }

        return $this;
    }

    public function removeTastingSheet(TastingSheet $tastingSheet): static
    {
        if ($this->tastingSheets->removeElement($tastingSheet)) {
            $tastingSheet->removeSmell($this);
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getNameSmell();
    }
}
