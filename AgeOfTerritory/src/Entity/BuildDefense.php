<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BuildDefenseRepository")
 */
class BuildDefense
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Defense", inversedBy="buildDefenses", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $defense;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Isle", inversedBy="buildDefenses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $isle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $damage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $health;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $woodCost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stoneCost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $metalCost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $buildTime;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbTemp;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDefense(): ?Defense
    {
        return $this->defense;
    }

    public function setDefense(?Defense $defense): self
    {
        $this->defense = $defense;

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

    public function getDamage(): ?int
    {
        return $this->damage;
    }

    public function setDamage(int $damage): self
    {
        $this->damage = $damage;

        return $this;
    }

    public function getHealth(): ?int
    {
        return $this->health;
    }

    public function setHealth(int $health): self
    {
        $this->health = $health;

        return $this;
    }

    public function getWoodCost(): ?int
    {
        return $this->woodCost;
    }

    public function setWoodCost(int $woodCost): self
    {
        $this->woodCost = $woodCost;

        return $this;
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


    public function getBuildTime()
    {
        return $this->buildTime;
    }

    public function setBuildTime($buildTime): void
    {
        $this->buildTime = $buildTime;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
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

    /**
     * @return mixed
     */
    public function getNbTemp()
    {
        return $this->nbTemp;
    }

    /**
     * @param mixed $nbTemp
     */
    public function setNbTemp($nbTemp): void
    {
        $this->nbTemp = $nbTemp;
    }



}
