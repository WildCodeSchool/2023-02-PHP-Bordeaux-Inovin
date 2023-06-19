<?php
namespace App\Entity;
trait EntityTrait
{
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addArome($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeArome($this);
        }

        return $this;
    }

    public function getGouts(): Collection
    {
        return $this->gouts;
    }

    public function addGout(Gout $gout): self
    {
        if (!$this->gouts->contains($gout)) {
            $this->gouts->add($gout);
            $gout->addArome($this);
        }

        return $this;
    }

    public function removeGout(Gout $gout): self
    {
        if ($this->gouts->removeElement($gout)) {
            $gout->removeArome($this);
        }

        return $this;
    }
}
