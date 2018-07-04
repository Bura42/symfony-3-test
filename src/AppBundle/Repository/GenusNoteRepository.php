<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 03/07/18
 * Time: 16:25
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Genus;
use Doctrine\ORM\EntityRepository;

class GenusNoteRepository extends EntityRepository {

  public function findAllRecentNotesForGenus(Genus $genus) {
    return $this->createQueryBuilder('genus_note')
      ->andWhere('genus_note.genus =:genus')
      ->setParameter('genus', $genus)
      ->andWhere('genus_note.createdAt > :recentDate')
      ->setParameter('recentDate', new \DateTime('-3 month'))
      ->getQuery()
      ->execute();
  }
}