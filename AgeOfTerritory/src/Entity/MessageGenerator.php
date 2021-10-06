<?php
namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Message;


class MessageGenerator{

    public static function generatorRapportEspionnage($author, $recipient, ObjectManager $manager, $cible)
    {

        $rapportEspionnage = new Message();
        $rapportEspionnage->setAuthor($author);
        $rapportEspionnage->setRecipient($recipient);
        $rapportEspionnage->setCible($cible);
        $rapportEspionnage->setTitle("Rapport d'espionnage");
        $rapportEspionnage->setCreatedDate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($rapportEspionnage);
        $manager->flush($rapportEspionnage);
    }

    public static function generatorAlertEspionnage($author, $recipient, ObjectManager $manager)
    {

        $alertEspionnage = new Message();
        $alertEspionnage->setAuthor($author);
        $alertEspionnage->setRecipient($recipient);
        $alertEspionnage->setTitle("Alert: Espionnage de votre île !");
        $alertEspionnage->setCreatedDate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($alertEspionnage);
        $manager->flush($alertEspionnage);
    }
    public static function generatorMessageInscription($author, $recipient, ObjectManager $manager)
    {

        $messageInscription = new Message();
        $messageInscription->setAuthor($author);
        $messageInscription->setRecipient($recipient);
        $messageInscription->setTitle("Merci pour votre inscription !");
        $messageInscription->setCreatedDate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $manager->persist($messageInscription);
        $manager->flush($messageInscription);
    }
}
