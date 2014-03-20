<?php
namespace Seven\FEBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Seven\FEBundle\Entity\ProviderAccount;

class LoadProviderAccountData extends AbstractFixture implements  OrderedFixtureInterface
{
    function load(ObjectManager $manager)
    {
        $provider_account = new ProviderAccount();
        $provider_account->setClient($manager->merge($this->getReference("client")));
        $provider_account->setServiceProvider($manager->merge($this->getReference("service_provider")));
        $provider_account->setName("GD1");
        $provider_account->setUsername("username1");
        $provider_account->setPassword("password1");
        $manager->persist($provider_account);


        $provider_account1 = new ProviderAccount();
        $provider_account1->setClient($manager->merge($this->getReference("client")));
        $provider_account1->setServiceProvider($manager->merge($this->getReference("service_provider")));
        $provider_account1->setName("GD2");
        $provider_account1->setUsername("username2");
        $provider_account1->setPassword("password2");
        $manager->persist($provider_account1);


        $provider_account2 = new ProviderAccount();
        $provider_account2->setClient($manager->merge($this->getReference("client")));
        $provider_account2->setServiceProvider($manager->merge($this->getReference("service_provider1")));
        $provider_account2->setName("FC1");
        $provider_account2->setUsername("username1");
        $provider_account2->setPassword("password1");
        $manager->persist($provider_account2);

        $manager->flush();
    }

    function getOrder()
    {
        return 3;
    }
}