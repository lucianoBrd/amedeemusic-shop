<?php

namespace App\Repository\BannerImage;

use App\Entity\BannerImage\BannerImage;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 *
 * @method BannerImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method BannerImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method BannerImage[]    findAll()
 * @method BannerImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BannerImageRepository extends EntityRepository
{

//    /**
//     * @return BannerImage[] Returns an array of BannerImage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BannerImage
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
