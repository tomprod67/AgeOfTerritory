<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchTechnologyRepository")
 */
class SearchTechnology
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Technology", inversedBy="searchTechnologies", fetch="EAGER")
     */
    private $technology;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Isle", inversedBy="searchTechnologies")
     */
    private $isle;

    /**
     * @ORM\Column(type="integer")
     */
    private $levelTechnology;

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
     * @ORM\Column(type="integer")
     */
    private $searchTime;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $endDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTechnology(): ?Technology
    {
        return $this->technology;
    }

    public function setTechnology(?Technology $technology): self
    {
        $this->technology = $technology;

        return $this;
    }

    public function getIsle(): ?Isle
    {
        return $this->isle;
    }

    public function setIsle(?Isle $isle): self
    {
        $this->isle = $isle;

        return $this;
    }

    public function getLevelTechnology(): ?int
    {
        return $this->levelTechnology;
    }

    public function setLevelTechnology(int $levelTechnology): self
    {
        $this->levelTechnology = $levelTechnology;

        return $this;
    }

    public function getWoodCost()
    {
        return $this->woodCost;
    }


    public function setWoodCost($woodCost): void
    {
        $this->woodCost = $woodCost;
    }



    public function getStoneCost(): ?int
    {
        return $this->stoneCost;
    }

    public function setStoneCost(int $stoneCost): self
    {
        $this->stoneCost = $stoneCost;

        return $this;
    }

    public function getMetalCost(): ?int
    {
        return $this->metalCost;
    }

    public function setMetalCost(int $metalCost): self
    {
        $this->metalCost = $metalCost;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSearchTime()
    {
        return $this->searchTime;
    }

    /**
     * @param mixed $searchTime
     */
    public function setSearchTime($searchTime): void
    {
        $this->searchTime = $searchTime;
    }

    public function upPowerPoint($totalCost)
    {
        if ($totalCost < 100 && $totalCost > 0) {
            $upPowerPoint = 1;
            return $upPowerPoint;
        } elseif ($totalCost > 100) {
            $upPowerPoint = $totalCost / 100;
            return $upPowerPoint;
        }
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
