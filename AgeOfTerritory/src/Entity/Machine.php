<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MachineRepository")
 */
class Machine
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
     * @ORM\OneToMany(targetEntity="App\Entity\TrainingMachine", mappedBy="machine")
     */
    private $trainingMachines;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="preferenceMachineSpy")
     */
    private $users;

    public function __construct()
    {
        $this->trainingMachines = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDamage(): ?int
    {
        return $this->damage;
    }


    /**
     * @return Collection|TrainingMachine[]
     */
    public function getTrainingMachines(): Collection
    {
        return $this->trainingMachines;
    }

    public function addTrainingMachine(TrainingMachine $trainingMachine): self
    {
        if (!$this->trainingMachines->contains($trainingMachine)) {
            $this->trainingMachines[] = $trainingMachine;
            $trainingMachine->setMachine($this);
        }

        return $this;
    }

    public function removeTrainingMachine(TrainingMachine $trainingMachine): self
    {
        if ($this->trainingMachines->contains($trainingMachine)) {
            $this->trainingMachines->removeElement($trainingMachine);
            // set the owning side to null (unless already changed)
            if ($trainingMachine->getMachine() === $this) {
                $trainingMachine->setMachine(null);
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
            $user->setPreferenceMachineSpy($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getPreferenceMachineSpy() === $this) {
                $user->setPreferenceMachineSpy(null);
            }
        }

        return $this;
    }
}
