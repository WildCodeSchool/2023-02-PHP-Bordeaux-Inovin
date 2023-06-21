<?php

namespace App\Entity;

use App\Repository\TastingSheetRepository;
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
}
