<?php

namespace ReclamationBundle\Repository;

/**
 * CoursRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CoursRepository extends \Doctrine\ORM\EntityRepository
{
    public function search($searchPara){
        $qb = $this ->createQueryBuilder('c');
        if (!empty($searchPara))
            extract($searchPara);
        if(!empty($categorie))
            $qb->Where('c.categorie LIKE :categorie')
                ->setParameter('categorie',$categorie);
        if(!empty($cible))
            $qb->andWhere('c.cible LIKE :cible')
                ->setParameter('cible',$cible);

        if(!empty($temps))
            $qb->andWhere('c.temps LIKE :temps')
                ->setParameter('temps',$temps);


        return $qb->getQuery()->getResult();
    }
}
