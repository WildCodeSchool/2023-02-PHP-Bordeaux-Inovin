<?php

namespace App\Entity;

use App\Repository\TasteRepository;
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
    private ?string $name_taste = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTaste(): ?string
    {
        return $this->name_taste;
    }

    public function setNameTaste(?string $name_taste): static
    {
        $this->name_taste = $name_taste;

        return $this;
    }
}
