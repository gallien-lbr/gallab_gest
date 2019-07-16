<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class InvoiceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /**
         * @var Invoice $invoice
         */
        $invoice = new Invoice();
        $invoice->setPaymentMaxDuration(30);
        $invoice->setReference('FA-ABCD');
        $invoice->setCreatedAt(new \DateTime());
        $invoice->setSentAt(new \DateTime());
        $invoice->setCustomer($this->getReference('customer-fixture'));
        $invoice->setPaymentMethod(null);
        $invoice->setCompany($this->getReference('fixture-company'));
        $invoice->setDescr('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent pellentesque tincidunt scelerisque. 
        Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.');
        $manager->persist($invoice);
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
                PaymentMethodFixtures::class,
                CustomerFixture::class,
        ];
    }
}
