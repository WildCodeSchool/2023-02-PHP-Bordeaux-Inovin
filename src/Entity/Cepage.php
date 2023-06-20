<?php

namespace App\Entity;

use App\Repository\CepageRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CepageRepository::class)]
class Cepage
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nameCepage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCepage(): ?string
    {
        return $this->nameCepage;
    }

    public function setNameCepage(string $nameCepage): static
    {
        $this->nameCepage = $nameCepage;

        return $this;
    }
}
