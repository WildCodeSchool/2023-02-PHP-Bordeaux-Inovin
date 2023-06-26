<?php

namespace App\Entity;

use App\Repository\WineBlendRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
#[ORM\Entity(repositoryClass: WineBlendRepository::class)]
class WineBlend
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameBlend = null;

    #[ORM\Column]
    private ?int $scoreWineblend = null;

    #[ORM\ManyToOne(inversedBy: 'wineBlends')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'wineBlends')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Workshop $workshop = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameBlend(): ?string
    {
        return $this->nameBlend;
    }

    public function setNameBlend(string $nameBlend): static
    {
        $this->nameBlend = $nameBlend;

        return $this;
    }

    public function getScoreWineblend(): ?int
    {
        return $this->scoreWineblend;
    }

    public function setScoreWineblend(int $scoreWineblend): static
    {
        $this->scoreWineblend = $scoreWineblend;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getWorkshop(): ?Workshop
    {
        return $this->workshop;
    }

    public function setWorkshop(?Workshop $workshop): static
    {
        $this->workshop = $workshop;

        return $this;
    }
}
