<?php
namespace Seven\FEBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class MiscRepository extends EntityRepository
{
    public function getMisc($client, $query, $isp)
    {
        $q = $this->getEntityManager()->createQueryBuilder()
            ->select('m')
            ->from('SevenFEBundle:Miscellaneous','m')
            ->where("m.client = :client")
            ->setParameter(":client", $client)
            ->orderBy("m.created_at", "DESC")
            ->leftJoin("m.provider_account", "pa")
            ->leftJoin("pa.service_provider", "sp")
        ;

        if($query !== null)
        {
            $q->add(
                'where',
                $q->expr()->orx(
                    $q->expr()->like('m.address', '?1'),
                    $q->expr()->like('m.notes', '?1'),
                    $q->expr()->like('m.description', '?1'),
                    $q->expr()->like('m.price', '?1'),
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