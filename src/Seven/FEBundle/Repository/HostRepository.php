<?php
namespace Seven\FEBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class HostRepository extends EntityRepository
{
    public function getHosts($client, $query, $isp)
    {
        $q = $this->getEntityManager()->createQueryBuilder()
            ->select('d, ftp, db, cp')
            ->from('SevenFEBundle:Host','d')
            ->where("d.client = :client")
            ->setParameter(":client", $client)
            ->orderBy("d.created_at", "DESC")
            ->leftJoin("d.ftp", "ftp")
            ->leftJoin("d.db", "db")
            ->leftJoin("d.cpanel", "cp")
            ->leftJoin("d.provider_account", "pa")
            ->leftJoin("pa.service_provider", "sp")
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