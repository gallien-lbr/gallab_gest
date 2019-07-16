<?php

namespace App\DataFixtures;

use App\Entity\InvoiceCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class InvoiceCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $payments = [];
        $types = ['Information Technology Services','Sales','Consulting'];

        for($i=0;$i <= count($types) - 1; $i++){
            $payments[$i] = new InvoiceCategory();
            $payments[$i]->setName($types[$i]);
            $manager->persist($payments[$i]);
        }


        $manager->flush();
    }
}
