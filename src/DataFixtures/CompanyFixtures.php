<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class CompanyFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var Generator */
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $company = new Company();
        $company->setSiret(
            $this->faker->randomNumber(2)
        );
        $company->setCodeNaf($this->faker->randomDigit(2));
        $company->setCountry($manager->merge($this->getReference('country-fr')));
        $company->setPhone($this->faker->phoneNumber);
        $company->setAddress1($this->faker->address);
        $company->setAddress2('');
        $company->setPostalCode($this->faker->postcode);
        $company->setCity($this->faker->city);

        $this->addReference('fixture-company', $company);
        $manager->persist($company);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CountriesFixtures::class,
        );
    }

}

