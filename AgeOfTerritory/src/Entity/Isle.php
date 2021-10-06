<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IsleRepository")
 */
class Isle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $size;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $longitude;

    /**
     * @ORM\Column(type="integer")
     */
    private $latitude;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="isles", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BuildDefense", mappedBy="isle")
     */
    private $buildDefenses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BuildBuilding", mappedBy="isle")
     */
    private $buildBuildings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrainingUnit", mappedBy="isle")
     */
    private $trainingUnits;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrainingMachine", mappedBy="isle")
     */
    private $trainingMachines;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $woodStock;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stoneStock;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $metalStock;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $oilStock;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $woodProd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stoneProd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $metalProd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $oilProd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $powerPoint;



    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="mainIsle")
     */
    private $userMainIsle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SearchTechnology", mappedBy="isle")
     */
    private $searchTechnologies;


    private $hitIsle;


    private $targetIsle;




    public function __construct()
    {
        $this->buildDefenses = new ArrayCollection();
        $this->buildBuildings = new ArrayCollection();
        $this->trainingUnits = new ArrayCollection();
        $this->trainingMachines = new ArrayCollection();
        $this->hitIsle = new ArrayCollection();
        $this->targetIsle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getSize()
    {
        return $this->size;
    }


    public function setSize($size): void
    {
        $this->size = $size;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }



    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
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
            $buildDefense->setIsle($this);
        }

        return $this;
    }

    public function removeBuildDefense(BuildDefense $buildDefense): self
    {
        if ($this->buildDefenses->contains($buildDefense)) {
            $this->buildDefenses->removeElement($buildDefense);
            // set the owning side to null (unless already changed)
            if ($buildDefense->getIsle() === $this) {
                $buildDefense->setIsle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BuildBuilding[]*
     */
    public function getBuildBuildings(): Collection
    {
        return $this->buildBuildings;
    }

    public function addBuildBuilding(BuildBuilding $buildBuilding): self
    {
        if (!$this->buildBuildings->contains($buildBuilding)) {
            $this->buildBuildings[] = $buildBuilding;
            $buildBuilding->setIsle($this);
        }

        return $this;
    }

    public function removeBuildBuilding(BuildBuilding $buildBuilding): self
    {
        if ($this->buildBuildings->contains($buildBuilding)) {
            $this->buildBuildings->removeElement($buildBuilding);
            // set the owning side to null (unless already changed)
            if ($buildBuilding->getIsle() === $this) {
                $buildBuilding->setIsle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TrainingUnit[]
     */
    public function getTrainingUnits(): Collection
    {
        return $this->trainingUnits;
    }

    public function addTrainingUnit(TrainingUnit $trainingUnit): self
    {
        if (!$this->trainingUnits->contains($trainingUnit)) {
            $this->trainingUnits[] = $trainingUnit;
            $trainingUnit->setIsle($this);
        }

        return $this;
    }

    public function removeTrainingUnit(TrainingUnit $trainingUnit): self
    {
        if ($this->trainingUnits->contains($trainingUnit)) {
            $this->trainingUnits->removeElement($trainingUnit);
            // set the owning side to null (unless already changed)
            if ($trainingUnit->getIsle() === $this) {
                $trainingUnit->setIsle(null);
            }
        }

        return $this;
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
            $trainingMachine->setIsle($this);
        }

        return $this;
    }

    public function removeTrainingMachine(TrainingMachine $trainingMachine): self
    {
        if ($this->trainingMachines->contains($trainingMachine)) {
            $this->trainingMachines->removeElement($trainingMachine);
            // set the owning side to null (unless already changed)
            if ($trainingMachine->getIsle() === $this) {
                $trainingMachine->setIsle(null);
            }
        }

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
            $searchTechnology->setIsle($this);
        }

        return $this;
    }

    public function removeSearchTechnology(SearchTechnology $searchTechnology): self
    {
        if ($this->searchTechnologies->contains($searchTechnology)) {
            $this->searchTechnologies->removeElement($searchTechnology);
            // set the owning side to null (unless already changed)
            if ($searchTechnology->getIsle() == $this) {
                $searchTechnology->setIsle(null);
            }
        }

        return $this;
    }

    public function getWoodStock(): ?int
    {
        return $this->woodStock;
    }

    public function setWoodStock(int $woodStock): self
    {
        $this->woodStock = $woodStock;

        return $this;
    }

    public function getStoneStock(): ?int
    {
        return $this->stoneStock;
    }

    public function setStoneStock(int $stoneStock): self
    {
        $this->stoneStock = $stoneStock;

        return $this;
    }

    public function getMetalStock(): ?int
    {
        return $this->metalStock;
    }

    public function setMetalStock(int $metalStock): self
    {
        $this->metalStock = $metalStock;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOilStock()
    {
        return $this->oilStock;
    }

    /**
     * @param mixed $oilStock
     */
    public function setOilStock($oilStock): void
    {
        $this->oilStock = $oilStock;
    }



    public function getPowerPoint(): ?int
    {
        return $this->powerPoint;
    }

    public function setPowerPoint(?int $powerPoint): self
    {
        $this->powerPoint = $powerPoint;

        return $this;
    }


    public function getUserMainIsle(): ?User
    {
        return $this->userMainIsle;
    }

    public function setUserMainIsle(User $userMainIsle): self
    {
        $this->userMainIsle = $userMainIsle;

        // set the owning side of the relation if necessary
        if ($this !== $userMainIsle->getMainIsle()) {
            $userMainIsle->setMainIsle($this);
        }

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function gethitIsle(): Collection
    {
        return $this->hitIsle;
    }

    public function addhitIsle(Mission $hitIsle): self
    {
        if (!$this->hitIsle->contains($hitIsle)) {
            $this->hitIsle[] = $hitIsle;
            $hitIsle->setIsle($this);
        }

        return $this;
    }

    public function removehitIsle(Mission $hitIsle): self
    {
        if ($this->hitIsle->contains($hitIsle)) {
            $this->hitIsle->removeElement($hitIsle);
            // set the owning side to null (unless already changed)
            if ($hitIsle->getIsle() === $this) {
                $hitIsle->setIsle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getTargetIsle(): Collection
    {
        return $this->targetIsle;
    }

    public function addTargetIsle(Mission $targetIsle): self
    {
        if (!$this->targetIsle->contains($targetIsle)) {
            $this->targetIsle[] = $targetIsle;
            $targetIsle->setTargetIsle($this);
        }

        return $this;
    }

    public function removeTargetIsle(Mission $targetIsle): self
    {
        if ($this->targetIsle->contains($targetIsle)) {
            $this->targetIsle->removeElement($targetIsle);
            // set the owning side to null (unless already changed)
            if ($targetIsle->getTargetIsle() === $this) {
                $targetIsle->setTargetIsle(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWoodProd()
    {
        return $this->woodProd;
    }

    /**
     * @param mixed $woodProd
     */
    public function setWoodProd($woodProd): void
    {
        $this->woodProd = $woodProd;
    }

    /**
     * @return mixed
     */
    public function getStoneProd()
    {
        return $this->stoneProd;
    }

    /**
     * @param mixed $stoneProd
     */
    public function setStoneProd($stoneProd): void
    {
        $this->stoneProd = $stoneProd;
    }

    /**
     * @return mixed
     */
    public function getMetalProd()
    {
        return $this->metalProd;
    }

    /**
     * @param mixed $metalProd
     */
    public function setMetalProd($metalProd): void
    {
        $this->metalProd = $metalProd;
    }

    /**
     * @return mixed
     */
    public function getOilProd()
    {
        return $this->oilProd;
    }

    /**
     * @param mixed $oilProd
     */
    public function setOilProd($oilProd): void
    {
        $this->oilProd = $oilProd;
    }

    public function __toString()
    {
        return $this->name;
    }


}
