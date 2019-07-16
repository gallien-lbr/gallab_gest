<?php

namespace App\DataFixtures;

use App\Entity\LineUnit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LineUnitFixtures extends Fixture
{
    public function load(ObjectManager $em)
    {
        $references = ['Jour(s)','Heure(s)'];
        $records = [];
        $i = 0;

        foreach ($references as $unit){
            $records[$i] = new LineUnit();
            $records[$i]->setName($unit) ;
            $em->persist($records[$i]);
            $i++;
        }

        $em->flush();
    }
}
