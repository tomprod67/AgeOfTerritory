<?php

namespace App\Entity;

use App\Entity\BuildBuilding;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Rsa\Sha256;

class MercureCookieGenerator{

    private $secret;

    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    public function generate(BuildBuilding $buildBuilding){
        $token = (new Builder())
            ->set('mercure', ['subscribe' => ["http://localhost:8000/game/building/{$buildBuilding->getId()}" ]] )
            ->sign(new Sha256(), $this->secret)
            ->getToken();
        return "mercureAuthorization={$token}; Path=/hub; HttpOnly;";
    }
}