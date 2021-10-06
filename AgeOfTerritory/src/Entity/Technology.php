<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TechnologyRepository")
 */
class Technology
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
     * @ORM\OneToMany(targetEntity="App\Entity\SearchTechnology", mappedBy="technology")
     */
    private $searchTechnologies;

    public function __construct()
    {
        $this->searchTechnologies = new ArrayCollection();
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
     * @return Collection|SearchTechnology[]
     */
    public function getSearchTechnologies(): Collection
    {
        return $this->searchTechnologies;
    }

    public function addSearchTechnology(SearchTechnology $searchTechnology): self
    {
        if (!$this->searchTechnologies->contains($searchTechnology)) {
            $this->searchTechnologies[] = $searchTechnology;
            $searchTechnology->setTechnology($this);
        }

        return $this;
    }

    public function removeSearchTechnology(SearchTechnology $searchTechnology): self
    {
        if ($this->searchTechnologies->contains($searchTechnology)) {
            $this->searchTechnologies->removeElement($searchTechnology);
            // set the owning side to null (unless already changed)
            if ($searchTechnology->getTechnology() === $this) {
                $searchTechnology->setTechnology(null);
            }
        }

        return $this;
    }
}
