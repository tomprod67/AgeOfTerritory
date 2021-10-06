<?php
namespace App\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\SearchTechnology;

class TechnologyGenerator{

    public static function generatorTechnology(){
        return ["TechniqueSciage", "TechniqueExploitationPierre", "TechniqueExtractionMetal",
            "TechniqueSynthetisation", "TechniqueTravailBois","TechniqueTravailPierre","TechniqueTravailMetal",
            "TechniqueEspionnage", "TechniqueFouille", "TechniqueConstruction", "TechniqueOffensive", "TechniqueDefensive"
        ];

    }

    public static function generatorTechniqueSciage($isle, ObjectManager $manager, $technology){
        $techniqueSciage = new SearchTechnology();
        $techniqueSciage->setIsle($isle);
        $techniqueSciage->setTechnology($technology);
        $techniqueSciage->setLevelTechnology(0);
        $techniqueSciage->setWoodCost(400);
        $techniqueSciage->setStoneCost(200);
        $techniqueSciage->setMetalCost(100);
        $techniqueSciage->setSearchTime(600);
        $manager->persist($techniqueSciage);
        $manager->flush();
    }

    public static function generatorTechniqueExploitationPierre($isle, ObjectManager $manager, $technology){
        $techniqueExploitationPierre = new SearchTechnology();
        $techniqueExploitationPierre->setIsle($isle);
        $techniqueExploitationPierre->setTechnology($technology);
        $techniqueExploitationPierre->setLevelTechnology(0);
        $techniqueExploitationPierre->setWoodCost(400);
        $techniqueExploitationPierre->setStoneCost(200);
        $techniqueExploitationPierre->setMetalCost(100);
        $techniqueExploitationPierre->setSearchTime(600);
        $manager->persist($techniqueExploitationPierre);
        $manager->flush();
    }

    public static function generatorTechniqueExtractionMetal($isle, ObjectManager $manager, $technology){
        $techniqueExtractionMetal = new SearchTechnology();
        $techniqueExtractionMetal->setIsle($isle);
        $techniqueExtractionMetal->setTechnology($technology);
        $techniqueExtractionMetal->setLevelTechnology(0);
        $techniqueExtractionMetal->setWoodCost(400);
        $techniqueExtractionMetal->setStoneCost(200);
        $techniqueExtractionMetal->setMetalCost(100);
        $techniqueExtractionMetal->setSearchTime(600);
        $manager->persist($techniqueExtractionMetal);
        $manager->flush();
    }

    public static function generatorTechniqueSynthetisation($isle, ObjectManager $manager, $technology){
        $techniqueSynthetisation = new SearchTechnology();
        $techniqueSynthetisation->setIsle($isle);
        $techniqueSynthetisation->setTechnology($technology);
        $techniqueSynthetisation->setLevelTechnology(0);
        $techniqueSynthetisation->setWoodCost(400);
        $techniqueSynthetisation->setStoneCost(200);
        $techniqueSynthetisation->setMetalCost(100);
        $techniqueSynthetisation->setSearchTime(600);
        $manager->persist($techniqueSynthetisation);
        $manager->flush();
    }


    public static function generatorTechniqueTravailBois($isle, ObjectManager $manager, $technology){
        $techniqueTravailBois = new SearchTechnology();
        $techniqueTravailBois->setIsle($isle);
        $techniqueTravailBois->setTechnology($technology);
        $techniqueTravailBois->setLevelTechnology(0);
        $techniqueTravailBois->setWoodCost(600);
        $techniqueTravailBois->setStoneCost(300);
        $techniqueTravailBois->setMetalCost(200);
        $techniqueTravailBois->setSearchTime(720);
        $manager->persist($techniqueTravailBois);
        $manager->flush();
    }

    public static function generatorTechniqueTravailPierre($isle, ObjectManager $manager, $technology){
        $techniqueTravailPierre = new SearchTechnology();
        $techniqueTravailPierre->setIsle($isle);
        $techniqueTravailPierre->setTechnology($technology);
        $techniqueTravailPierre->setLevelTechnology(0);
        $techniqueTravailPierre->setWoodCost(600);
        $techniqueTravailPierre->setStoneCost(300);
        $techniqueTravailPierre->setMetalCost(200);
        $techniqueTravailPierre->setSearchTime(720);
        $manager->persist($techniqueTravailPierre);
        $manager->flush();
    }

    public static function generatorTechniqueTravailMetal($isle, ObjectManager $manager, $technology){
        $techniqueTravailMetal = new SearchTechnology();
        $techniqueTravailMetal->setIsle($isle);
        $techniqueTravailMetal->setTechnology($technology);
        $techniqueTravailMetal->setLevelTechnology(0);
        $techniqueTravailMetal->setWoodCost(600);
        $techniqueTravailMetal->setStoneCost(300);
        $techniqueTravailMetal->setMetalCost(200);
        $techniqueTravailMetal->setSearchTime(720);
        $manager->persist($techniqueTravailMetal);
        $manager->flush();
    }

    public static function generatorTechniqueEspionnage($isle, ObjectManager $manager, $technology){
        $techniqueEspionnage = new SearchTechnology();
        $techniqueEspionnage->setIsle($isle);
        $techniqueEspionnage->setTechnology($technology);
        $techniqueEspionnage->setLevelTechnology(0);
        $techniqueEspionnage->setWoodCost(800);
        $techniqueEspionnage->setStoneCost(400);
        $techniqueEspionnage->setMetalCost(300);
        $techniqueEspionnage->setSearchTime(840);
        $manager->persist($techniqueEspionnage);
        $manager->flush();
    }

    public static function generatorTechniqueFouille($isle, ObjectManager $manager, $technology){
        $techniqueFouille = new SearchTechnology();
        $techniqueFouille->setIsle($isle);
        $techniqueFouille->setTechnology($technology);
        $techniqueFouille->setLevelTechnology(0);
        $techniqueFouille->setWoodCost(800);
        $techniqueFouille->setStoneCost(400);
        $techniqueFouille->setMetalCost(300);
        $techniqueFouille->setSearchTime(840);
        $manager->persist($techniqueFouille);
        $manager->flush();
    }

    public static function generatorTechniqueConstruction($isle, ObjectManager $manager, $technology){
        $techniqueConstruction = new SearchTechnology();
        $techniqueConstruction->setIsle($isle);
        $techniqueConstruction->setTechnology($technology);
        $techniqueConstruction->setLevelTechnology(0);
        $techniqueConstruction->setWoodCost(800);
        $techniqueConstruction->setStoneCost(400);
        $techniqueConstruction->setMetalCost(300);
        $techniqueConstruction->setSearchTime(840);
        $manager->persist($techniqueConstruction);
        $manager->flush();
    }

    public static function generatorTechniqueOffensive($isle, ObjectManager $manager, $technology){
        $techniqueOffensive = new SearchTechnology();
        $techniqueOffensive->setIsle($isle);
        $techniqueOffensive->setTechnology($technology);
        $techniqueOffensive->setLevelTechnology(0);
        $techniqueOffensive->setWoodCost(800);
        $techniqueOffensive->setStoneCost(400);
        $techniqueOffensive->setMetalCost(300);
        $techniqueOffensive->setSearchTime(840);
        $manager->persist($techniqueOffensive);
        $manager->flush();
    }

    public static function generatorTechniqueDefensive($isle, ObjectManager $manager, $technology){
        $techniqueDefensive = new SearchTechnology();
        $techniqueDefensive->setIsle($isle);
        $techniqueDefensive->setTechnology($technology);
        $techniqueDefensive->setLevelTechnology(0);
        $techniqueDefensive->setWoodCost(800);
        $techniqueDefensive->setStoneCost(400);
        $techniqueDefensive->setMetalCost(300);
        $techniqueDefensive->setSearchTime(840);
        $manager->persist($techniqueDefensive);
        $manager->flush();
    }

}