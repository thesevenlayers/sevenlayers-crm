<?php
namespace Seven\FEBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class DomainRepository extends EntityRepository
{
    public function getDomains($client, $query, $isp)
    {
        $q = $this->getEntityManager()->createQueryBuilder()
            ->select('d')
            ->from('SevenFEBundle:Domain','d')
            ->where("d.client = :client")
            ->setParameter(":client", $client)
            ->orderBy("d.created_at", "DESC")
            ->leftJoin("d.provider_account", "pa")
            ->leftJoin("pa.service_provider", "sp")
            ->leftJoin("sp.image_container", "ic")
            ->leftJoin("ic.images", "i")
        ;

        if($query !== null)
        {
            $q->add(
                'where',
                $q->expr()->orx(
                    $q->expr()->like('d.address', '?1'),
                    $q->expr()->like('d.notes', '?1'),
                    $q->expr()->like('d.description', '?1'),
                    $q->expr()->like('d.price', '?1'),
                    $q->expr()->like('sp.name', '?1')
                )
            )
                ->setParameters(array(
                        '1' => '%' . $query . '%',
                    ));
        }

        if($isp !== null)
        {
            $q->andWhere($q->expr()->notIn("sp.id", $isp));
        }

        return $q->getQuery()->getResult();
    }
}