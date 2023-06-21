<?php

namespace App\Entity;

use App\Repository\WorkshopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: WorkshopRepository::class)]
class Workshop
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameWorkshop = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateWorkshop = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $codeWorkshop = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $placeWorkshop = null;

    #[ORM\OneToMany(mappedBy: 'workshop', targetEntity: TastingSheet::class)]
    private Collection $tastingSheets;

    public function __construct()
    {
        $this->tastingSheets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameWorkshop(): ?string
    {
        return $this->nameWorkshop;
    }

    public function setNameWorkshop(?string $nameWorkshop): static
    {
        $this->nameWorkshop = $nameWorkshop;

        return $this;
    }

    public function getDateWorkshop(): ?\DateTimeInterface
    {
        return $this->dateWorkshop;
    }

    public function setDateWorkshop(?\DateTimeInterface $dateWorkshop): static
    {
        $this->dateWorkshop = $dateWorkshop;

        return $this;
    }

    public function getCodeWorkshop(): ?string
    {
        return $this->codeWorkshop;
    }

    public function setCodeWorkshop(?string $codeWorkshop): static
    {
        $this->codeWorkshop = $codeWorkshop;

        return $this;
    }

    public function getPlaceWorkshop(): ?string
    {
        return $this->placeWorkshop;
    }

    public function setPlaceWorkshop(?string $placeWorkshop): static
    {
        $this->placeWorkshop = $placeWorkshop;

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
            $tastingSheet->setWorkshop($this);
        }

        return $this;
    }

    public function removeTastingSheet(TastingSheet $tastingSheet): static
    {
        if ($this->tastingSheets->removeElement($tastingSheet)) {
            // set the owning side to null (unless already changed)
            if ($tastingSheet->getWorkshop() === $this) {
                $tastingSheet->setWorkshop(null);
            }
        }

        return $this;
    }
}
