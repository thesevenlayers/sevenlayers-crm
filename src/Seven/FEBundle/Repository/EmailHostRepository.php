<?php
namespace Seven\FEBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class EmailHostRepository extends EntityRepository
{
    public function getEmailHosts($client, $query, $isp)
    {
        $q = $this->getEntityManager()->createQueryBuilder()
            ->select('eh')
            ->from('SevenFEBundle:EmailHost','eh')
            ->where("eh.client = :client")
            ->setParameter(":client", $client)
            ->orderBy("eh.created_at", "DESC")
            ->leftJoin("eh.provider_account", "pa")
            ->leftJoin("pa.service_provider", "sp")
        ;

        if($query !== null)
        {
            $q->add(
                'where',
                $q->expr()->orx(
                    $q->expr()->like('eh.address', '?1'),
                    $q->expr()->like('eh.notes', '?1'),
                    $q->expr()->like('eh.description', '?1'),
                    $q->expr()->like('eh.price', '?1'),
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