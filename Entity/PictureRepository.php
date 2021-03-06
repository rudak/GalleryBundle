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
    public function getLastImage()
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('g')
            ->leftJoin('p.gallery', 'g')
            ->where('g.public = :public')->setParameter('public', true)
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery();
        return $qb->getOneOrNullResult();
    }

    public function getRandImage()
    {
        $qb       = $this->createQueryBuilder('p')
            ->addSelect('g')
            ->leftJoin('p.gallery', 'g')
            ->where('g.public = :public')->setParameter('public', true)
            ->orderBy('p.id', 'DESC')
            ->setMaxResults('200')
            ->getQuery();
        $pictures = $qb->execute();
        shuffle($pictures);
        return ($pictures) ? $pictures[0] : null;
    }

    public function getGalleryList()
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('g')
            ->leftJoin('p.gallery', 'g')
            ->groupBy('p.gallery')
            ->where('g.public = :public')->setParameter('public', true)
            ->orderBy('g.id', 'DESC')
            ->getQuery();
        return $qb->execute();
    }

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
