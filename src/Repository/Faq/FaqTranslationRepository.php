<?php

namespace App\Repository\Faq;

use App\Entity\Faq\FaqTranslation;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 *
 * @method FaqTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method FaqTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method FaqTranslation[]    findAll()
 * @method FaqTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FaqTranslationRepository extends EntityRepository
{

//    /**
//     * @return FaqTranslation[] Returns an array of FaqTranslation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FaqTranslation
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
