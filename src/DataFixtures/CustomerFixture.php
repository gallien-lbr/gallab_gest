<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class CustomerFixture extends Fixture implements DependentFixtureInterface
{
    /** @var Generator */
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $customer = new Customer();
        $customer->setName($this->faker->company);
        $customer->setContactName($this->faker->name());
        $customer->setCountry($manager->merge($this->getReference('country-ie')));
        $customer->setCity($this->faker->city);
        $customer->setPostalCode($this->faker->postcode);
        $customer->setAddress1($this->faker->streetAddress);
        $customer->setWebsite($this->faker->url);
        $customer->setEmail($this->faker->companyEmail);
        $this->addReference('customer-fixture', $customer);
        $manager->persist($customer);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CountriesFixtures::class,
        );
    }
}
