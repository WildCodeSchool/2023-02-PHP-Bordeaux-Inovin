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
    private ?string $nameTaste = null;

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
}
