<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 03/07/18
 * Time: 16:25
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class GenusRepository extends EntityRepository {

  /**
   * @return \AppBundle\Entity\Genus[]
   */
  public function findAllPublishedOrderedByRecentryActive() {
    return $this->createQueryBuilder('genus')
      ->andWhere('genus.isPublished = :isPublished')
      ->setParameter('isPublished', TRUE)
      ->leftJoin('genus.notes','genus_note')
      ->orderBy('genus_note.createdAt','DESC')
      ->getQuery()
      ->execute();
  }

}