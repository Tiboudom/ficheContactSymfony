<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contactJob;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstMail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $secondMail;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="cat_id")
     */
    private $Users;

    public function __construct()
    {
        $this->Users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactJob(): ?string
    {
        return $this->contactJob;
    }

    public function setContactJob(string $contactJob): self
    {
        $this->contactJob = $contactJob;

        return $this;
    }

    public function getFirstMail(): ?string
    {
        return $this->firstMail;
    }

    public function setFirstMail(string $firstMail): self
    {
        $this->firstMail = $firstMail;

        return $this;
    }

    public function getSecondMail(): ?string
    {
        return $this->secondMail;
    }

    public function setSecondMail(string $secondMail): self
    {
        $this->secondMail = $secondMail;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->Users;
    }

    public function addUser(User $user): self
    {
        if (!$this->Users->contains($user)) {
            $this->Users[] = $user;
            $user->setCatId($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->Users->contains($user)) {
            $this->Users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCatId() === $this) {
                $user->setCatId(null);
            }
        }

        return $this;
    }
}
