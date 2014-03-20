<?php
namespace Seven\FEBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ProviderAccountRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array("created_at" => "desc"));
    }

    public function getProviderAccounts($query, $isp)
    {
        $q = $this->getEntityManager()->createQueryBuilder()
            ->select('pa, cl, sp')
            ->from('SevenFEBundle:ProviderAccount','pa')
            ->orderBy("pa.created_at", "DESC")
            ->leftJoin("pa.client", "cl")
            ->leftJoin("pa.service_provider", "sp")
        ;

        if($query !== null)
        {
            $q->add(
                'where',
                $q->expr()->orx(
                    $q->expr()->like('pa.name', '?1'),
                    $q->expr()->like('pa.username', '?1'),
                    $q->expr()->like('pa.password', '?1'),
                    $q->expr()->like('sp.name', '?1'),
                    $q->expr()->like('cl.name', '?1')
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