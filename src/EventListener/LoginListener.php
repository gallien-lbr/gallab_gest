<?php

// src/EventListener/LoginListener.php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use App\Entity\User;

class LoginListener
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        // Get the User entity.
        /**
         * @var User $user
         */
        $user = $event->getAuthenticationToken()->getUser();


        // Update your fields here.
        $user->setLastLogin(new \DateTime());
        $user->setLastIp($event->getRequest()->getClientIp());

        // Persist the data to database.
        $this->em->persist($user);
        $this->em->flush();
    }
}