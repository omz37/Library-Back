<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener {

    /**
     * Fonction onAuthenticationSuccessResponse
     * qui permet si l'authentification réussie d'envoyer
     * une réponse contenant les infos de l'utilisateur connecté
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['user'] = array(
            'id' => $user->getID(),
            'name' => $user->getName(),
            'familyName' => $user->getFamilyName(),
            'email' => $user->getUserIdentifier(),
            'roles' => $user->getRoles()
        );

        $event->setData($data);
    }
}
