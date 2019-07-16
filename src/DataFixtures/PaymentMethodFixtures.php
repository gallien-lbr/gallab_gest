<?php

namespace App\DataFixtures;

use App\Entity\PaymentMethod;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PaymentMethodFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $payments = [];
        $types = ["Virement", "Espèces", "Chèque",  "Carte Bleue"];

        for($i=0;$i <= count($types) - 1; $i++){
            $payments[$i] = new PaymentMethod();
            $payments[$i]->setName($types[$i]);
            $manager->persist($payments[$i]);
        }

        $manager->flush();
    }
}
