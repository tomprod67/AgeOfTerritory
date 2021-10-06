<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DefenseRepository")
 */
class Defense
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BuildDefense", mappedBy="defense")
     */
    private $buildDefenses;

    public function __construct()
    {
        $this->buildDefenses = new ArrayCollection();
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

    /**
     * @return Collection|BuildDefense[]
     */
    public function getBuildDefenses(): Collection
    {
        return $this->buildDefenses;
    }

    public function addBuildDefense(BuildDefense $buildDefense): self
    {
        if (!$this->buildDefenses->contains($buildDefense)) {
            $this->buildDefenses[] = $buildDefense;
            $buildDefense->setDefense($this);
        }

        return $this;
    }

    public function removeBuildDefense(BuildDefense $buildDefense): self
    {
        if ($this->buildDefenses->contains($buildDefense)) {
            $this->buildDefenses->removeElement($buildDefense);
            // set the owning side to null (unless already changed)
            if ($buildDefense->getDefense() === $this) {
                $buildDefense->setDefense(null);
            }
        }

        return $this;
    }
}
