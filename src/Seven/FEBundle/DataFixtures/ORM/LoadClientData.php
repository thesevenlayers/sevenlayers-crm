<?php
namespace Seven\FEBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Seven\FEBundle\Entity\Client;

class LoadClientData extends AbstractFixture implements  OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setName("raf");
        $client->setAddress("addr1");
        $manager->persist($client);
        $manager->flush();
        $this->setReference("client", $client);
    }

    function getOrder()
    {
        return 2;
    }
}