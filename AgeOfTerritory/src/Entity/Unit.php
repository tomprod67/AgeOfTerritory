<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnitRepository")
 */
class Unit
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrainingUnit", mappedBy="unit")
     */
    private $trainingUnits;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="preferenceUnitSpy")
     */
    private $users;

    /**
     * Unit constructor.
     */
    public function __construct()
    {
        $this->trainingUnits = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Unit
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Unit
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     * @return Unit
     */
    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }


    /**
     * @return Collection|TrainingUnit[]
     */
    public function getTrainingUnits(): Collection
    {
        return $this->trainingUnits;
    }

    /**
     * @param TrainingUnit $trainingUnit
     * @return Unit
     */
    public function addTrainingUnit(TrainingUnit $trainingUnit): self
    {
        if (!$this->trainingUnits->contains($trainingUnit)) {
            $this->trainingUnits[] = $trainingUnit;
            $trainingUnit->setUnit($this);
        }

        return $this;
    }

    /**
     * @param TrainingUnit $trainingUnit
     * @return Unit
     */
    public function removeTrainingUnit(TrainingUnit $trainingUnit): self
    {
        if ($this->trainingUnits->contains($trainingUnit)) {
            $this->trainingUnits->removeElement($trainingUnit);
            // set the owning side to null (unless already changed)
            if ($trainingUnit->getUnit() === $this) {
                $trainingUnit->setUnit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setPreferenceUnitSpy($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getPreferenceUnitSpy() === $this) {
                $user->setPreferenceUnitSpy(null);
            }
        }

        return $this;
    }
}
