<?php

namespace App\Entity;

use App\Repository\WineBlendRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'wineBlend', targetEntity: TastingSheet::class)]
    private Collection $tastingSheets;

    #[ORM\OneToMany(mappedBy: 'wineBlend', targetEntity: Vote::class)]
    private Collection $votes;

    public function __construct()
    {
        $this->tastingSheets = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

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
            $tastingSheet->setWineBlend($this);
        }

        return $this;
    }

    public function removeTastingSheet(TastingSheet $tastingSheet): static
    {
        if ($this->tastingSheets->removeElement($tastingSheet)) {
            // set the owning side to null (unless already changed)
            if ($tastingSheet->getWineBlend() === $this) {
                $tastingSheet->setWineBlend(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): static
    {
        if (!$this->votes->contains($vote)) {
            $this->votes->add($vote);
            $vote->setWineBlend($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): static
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getWineBlend() === $this) {
                $vote->setWineBlend(null);
            }
        }

        return $this;
    }

}
