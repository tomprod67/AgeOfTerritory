<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MissionRepository")
 */
class Mission
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Isle", inversedBy="strikerIsle")
     */
    private $strikerIsle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Isle", inversedBy="targetIsle")
     */
    private $targetIsle;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $hitFreight;


    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $strikerTroops = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $targetTroopsAndDefenses = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mission;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $result;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat;


    public function getId(): ?int
    {
        return $this->id;
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
    public function getStrikerIsle()
    {
        return $this->strikerIsle;
    }

    /**
     * @param mixed $strikerIsle
     */
    public function setStrikerIsle($strikerIsle): void
    {
        $this->strikerIsle = $strikerIsle;
    }

    /**
     * @return mixed
     */
    public function getTargetIsle()
    {
        return $this->targetIsle;
    }

    /**
     * @param mixed $targetIsle
     */
    public function setTargetIsle($targetIsle): void
    {
        $this->targetIsle = $targetIsle;
    }



    /**
     * @return mixed
     */
    public function getStrikerTroops()
    {
        return $this->strikerTroops;
    }

    /**
     * @param mixed $strikerTroops
     */
    public function setStrikerTroops($strikerTroops): void
    {
        $this->strikerTroops = $strikerTroops;
    }

    /**
     * @return mixed
     */
    public function getTargetTroopsAndDefenses()
    {
        return $this->targetTroopsAndDefenses;
    }

    /**
     * @param mixed $targetTroopsAndDefenses
     */
    public function setTargetTroopsAndDefenses($targetTroopsAndDefenses): void
    {
        $this->targetTroopsAndDefenses = $targetTroopsAndDefenses;
    }

    /**
     * @return mixed
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * @param mixed $mission
     */
    public function setMission($mission): void
    {
        $this->mission = $mission;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(?string $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHitFreight()
    {
        return $this->hitFreight;
    }

    /**
     * @param mixed $hitFreight
     */
    public function setHitFreight($hitFreight): void
    {
        $this->hitFreight = $hitFreight;
    }




}
