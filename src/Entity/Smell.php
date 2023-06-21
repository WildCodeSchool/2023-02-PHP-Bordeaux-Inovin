<?php

namespace App\Entity;

use App\Repository\SmellRepository;
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
}
