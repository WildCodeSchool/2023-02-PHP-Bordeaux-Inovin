<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[ORM\JoinColumn(nullable: true)]
    private ?int $scoreVote = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    private ?User $user = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'votes')]
    private ?WineBlend $wineBlend = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'votes')]
    private ?Workshop $workshop = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScoreVote(): ?int
    {
        return $this->scoreVote;
    }

    public function setScoreVote(int $scoreVote): static
    {
        $this->scoreVote = $scoreVote;

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

    public function getWineBlend(): ?WineBlend
    {
        return $this->wineBlend;
    }

    public function setWineBlend(?WineBlend $wineBlend): static
    {
        $this->wineBlend = $wineBlend;

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
