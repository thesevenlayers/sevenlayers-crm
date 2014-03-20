<?php
namespace Seven\FEBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ClientContactRepository extends EntityRepository
{
    public function getContacts($client, $query)
    {
        $q = $this->getEntityManager()->createQueryBuilder()
            ->select('co')
            ->from('SevenFEBundle:ClientContact','co')
            ->where("co.client = :client")
            ->setParameter(":client", $client)
            ->orderBy("co.created_at", "DESC");

        if($query != null)
        {
            $q->add(
                'where',
                $q->expr()->orx(
                    $q->expr()->like('co.name', '?1'),
                    $q->expr()->like('co.email', '?1'),
                    $q->expr()->like('co.phone', '?1'),
                    $q->expr()->like('co.department', '?1'),
                    $q->expr()->like('co.title', '?1')
                )
            )
                ->setParameters(array('1' => '%' . $query . '%'));
        }

        return $q->getQuery()->getResult();
    }
}