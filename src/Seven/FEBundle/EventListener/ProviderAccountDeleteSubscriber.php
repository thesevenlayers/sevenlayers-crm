<?php
namespace Seven\FEBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Seven\FEBundle\Entity\ProviderAccount;

class ProviderAccountDeleteSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'preRemove'
        );
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $em = $args->getEntityManager();
        $entity = $args->getEntity();

        if($entity instanceof ProviderAccount)
        {
            $domains = $em->getRepository("SevenFEBundle:Domain")->findBy(array("provider_account" => $entity));
            foreach($domains as $domain)
            {
                $em->remove($domain);
            }

            $hosts = $em->getRepository("SevenFEBundle:Host")->findBy(array("provider_account" => $entity));
            foreach($hosts as $host)
            {
                $em->remove($host);
            }

            $email_hosts = $em->getRepository("SevenFEBundle:EmailHost")->findBy(array("provider_account" => $entity));
            foreach($email_hosts as $email_host)
            {
                $em->remove($email_host);
            }

            $maintenances = $em->getRepository("SevenFEBundle:Maintenance")->findBy(array("provider_account" => $entity));
            foreach($maintenances as $maintenance)
            {
                $em->remove($maintenance);
            }

            $miscs = $em->getRepository("SevenFEBundle:Miscellaneous")->findBy(array("provider_account" => $entity));
            foreach($miscs as $misc)
            {
                $em->remove($misc);
            }
            $em->flush();
        }
    }
}