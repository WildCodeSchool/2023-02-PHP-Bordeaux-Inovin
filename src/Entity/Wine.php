<?php

namespace App\Entity;

use App\Repository\WineRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: WineRepository::class)]
class Wine
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $producer = null;

    #[ORM\ManyToOne(inversedBy: 'wines')]
    private ?Color $color = null;

    #[ORM\ManyToOne(inversedBy: 'wines')]
    private ?Cepage $cepage = null;

    #[ORM\Column(length: 4)]
    private ?string $productionYear = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducer(): ?string
    {
        return $this->producer;
    }

    public function setProducer(string $producer): static
    {
        $this->producer = $producer;

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getCepage(): ?Cepage
    {
        return $this->cepage;
    }

    public function setCepage(?Cepage $cepage): static
    {
        $this->cepage = $cepage;

        return $this;
    }

    public function getProductionYear(): ?string
    {
        return $this->productionYear;
    }

    public function setProductionYear(string $productionYear): static
    {
        $this->productionYear = $productionYear;

        return $this;
    }
}
