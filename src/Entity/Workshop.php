<?php

namespace App\Entity;

use App\Repository\WorkshopRepository;
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
    private ?string $name_workshop = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_workshop = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $code_workshop = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $place_workshop = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameWorkshop(): ?string
    {
        return $this->name_workshop;
    }

    public function setNameWorkshop(?string $name_workshop): static
    {
        $this->name_workshop = $name_workshop;

        return $this;
    }

    public function getDateWorkshop(): ?\DateTimeInterface
    {
        return $this->date_workshop;
    }

    public function setDateWorkshop(?\DateTimeInterface $date_workshop): static
    {
        $this->date_workshop = $date_workshop;

        return $this;
    }

    public function getCodeWorkshop(): ?string
    {
        return $this->code_workshop;
    }

    public function setCodeWorkshop(?string $code_workshop): static
    {
        $this->code_workshop = $code_workshop;

        return $this;
    }

    public function getPlaceWorkshop(): ?string
    {
        return $this->place_workshop;
    }

    public function setPlaceWorkshop(?string $place_workshop): static
    {
        $this->place_workshop = $place_workshop;

        return $this;
    }
}
