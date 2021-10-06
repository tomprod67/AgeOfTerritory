<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingMachineRepository")
 */
class TrainingMachine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Machine", inversedBy="trainingMachines", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $machine;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Isle", inversedBy="trainingMachines")
     * @ORM\JoinColumn(nullable=false)
     */
    private $isle;

    /**
     * @ORM\Column(type="integer")
     */
    private $damage;

    /**
     * @ORM\Column(type="integer")
     */
    private $health;

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
    private $fuelConsumption;

    /**
     * @ORM\Column(type="integer")
     */
    private $freightCapacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $speed;

    /**
     * @ORM\Column(type="integer")
     */
    private $trainingTime;

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
    private $nombre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbTemp;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMachine(): ?Machine
    {
        return $this->machine;
    }

    public function setMachine(?Machine $machine): self
    {
        $this->machine = $machine;

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

    /**
     * @return mixed
     */
    public function getFuelConsumption()
    {
        return $this->fuelConsumption;
    }

    /**
     * @param mixed $fuelConsumption
     */
    public function setFuelConsumption($fuelConsumption): void
    {
        $this->fuelConsumption = $fuelConsumption;
    }

    /**
     * @return mixed
     */
    public function getFreightCapacity()
    {
        return $this->freightCapacity;
    }

    /**
     * @param mixed $freightCapacity
     */
    public function setFreightCapacity($freightCapacity): void
    {
        $this->freightCapacity = $freightCapacity;
    }

    /**
     * @return mixed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @param mixed $speed
     */
    public function setSpeed($speed): void
    {
        $this->speed = $speed;
    }



    public function getTrainingTime()
    {
        return $this->trainingTime;
    }


    public function setTrainingTime($trainingTime): void
    {
        $this->trainingTime = $trainingTime;
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

}
