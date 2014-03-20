<?php
namespace Seven\FEBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ClientRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array("created_at" => "desc"));
    }

    public function getClientsWithImages($search_query)
    {
        $q = $this->createQueryBuilder("c");
        $q->select("c", "con", "ic", "i")
            ->leftJoin("c.contacts", "con")
            ->leftJoin("c.image_container", "ic")
            ->leftJoin("ic.images", "i");
        if($search_query != null)
        {
            $q->add(
                "where",
                $q->expr()->orX(
                    $q->expr()->like("c.name", ":q"),
                    $q->expr()->like("c.address", ":q")
                )
            )->setParameter("q", "%{$search_query}%");
        }
        $q->orderBy("c.created_at", "desc")
            ->getQuery();
        return $q->getQuery()->getResult();
    }

}