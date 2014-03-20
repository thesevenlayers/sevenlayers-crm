<?php
namespace Seven\FEBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ServiceProviderRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array("created_at" => "desc"));
    }

    public function getServiceProviders($query, $isp)
    {
        $q = $this->getEntityManager()->createQueryBuilder()
            ->select('sp, ic, i')
            ->from('SevenFEBundle:ServiceProvider','sp')
            ->orderBy("sp.created_at", "DESC")
            ->leftJoin("sp.image_container", "ic")
            ->leftJoin("ic.images", "i")
        ;

        if($query !== null)
        {
            $q->add(
                'where',
                $q->expr()->orx(
                    $q->expr()->like('sp.name', '?1'),
                    $q->expr()->like('sp.address', '?1')
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