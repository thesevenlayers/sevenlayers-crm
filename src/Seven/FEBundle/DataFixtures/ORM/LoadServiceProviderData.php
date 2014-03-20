<?php
namespace Seven\FEBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Seven\FEBundle\Entity\ServiceProvider;

class LoadServiceProviderData extends AbstractFixture implements  OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
        $service_provider = new ServiceProvider();
        $service_provider->setName("Godaddy");
        $manager->persist($service_provider);

        $service_provider1 = new ServiceProvider();
        $service_provider1->setName("FatCow");
        $manager->persist($service_provider1);

        $manager->flush();
        $this->setReference("service_provider", $service_provider);
        $this->setReference("service_provider1", $service_provider1);
    }

    function getOrder()
    {
        return 1;
    }
}