<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BuildBuildingRepository")
 */
class BuildBuilding
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Building", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $building;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Isle", inversedBy="buildBuildings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $isle;

    /**
     * @ORM\Column(type="integer")
     */
    private $levelBuilding;

    /**
     * @ORM\Column(type="integer")
     */
    private $woodCost;

    /**
     * @ORM\Column(type="integer")
     */
    private $stoneCost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $metalCost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $buildingProd;

    /**
     * @ORM\Column(type="integer")
     */
    private $buildTime;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $endDate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param mixed $building
     */
    public function setBuilding($building): void
    {
        $this->building = $building;
    }

    /**
     * @return mixed
     */
    public function getIsle()
    {
        return $this->isle;
    }

    /**
     * @param mixed $isle
     */
    public function setIsle($isle): void
    {
        $this->isle = $isle;
    }

    /**
     * @return mixed
     */
    public function getLevelBuilding()
    {
        return $this->levelBuilding;
    }

    /**
     * @param mixed $levelBuilding
     */
    public function setLevelBuilding($levelBuilding): void
    {
        $this->levelBuilding = $levelBuilding;
    }

    /**
     * @return mixed
     */
    public function getWoodCost()
    {
        return $this->woodCost;
    }

    /**
     * @param mixed $woodCost
     */
    public function setWoodCost($woodCost): void
    {
        $this->woodCost = $woodCost;
    }

    /**
     * @return mixed
     */
    public function getStoneCost()
    {
        return $this->stoneCost;
    }

    /**
     * @param mixed $stoneCost
     */
    public function setStoneCost($stoneCost): void
    {
        $this->stoneCost = $stoneCost;
    }

    /**
     * @return mixed
     */
    public function getMetalCost()
    {
        return $this->metalCost;
    }

    /**
     * @param mixed $metalCost
     */
    public function setMetalCost($metalCost): void
    {
        $this->metalCost = $metalCost;
    }

    /**
     * @return mixed
     */
    public function getBuildingProd()
    {
        return $this->buildingProd;
    }

    /**
     * @param mixed $buildingProd
     */
    public function setBuildingProd($buildingProd): void
    {
        $this->buildingProd = $buildingProd;
    }

    /**
     * @return mixed
     */
    public function getBuildTime()
    {
        return $this->buildTime;
    }

    /**
     * @param mixed $buildTime
     */
    public function setBuildTime($buildTime): void
    {
        $this->buildTime = $buildTime;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }
}
