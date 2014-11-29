<?php

namespace Rudak\GalleryBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PictureRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PictureRepository extends EntityRepository
{
    public function getPicturesListAdmin()
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('g')
            ->leftJoin('p.gallery', 'g')
            ->orderBy('g.name')
            ->addOrderBy('p.id', 'DESC')
            ->getQuery();
        return $qb->execute();
    }


    public function getPicturesByIdAdmin($id)
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('g')
            ->leftJoin('p.gallery', 'g')
            ->where('p.id = :id')->setParameter('id', $id)
            ->getQuery();
        return $qb->getOneOrNullResult();
    }
}
