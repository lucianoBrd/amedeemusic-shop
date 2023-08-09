<?php

namespace App\Repository\ProductBundle;

use App\Entity\Product\Product;
use App\Entity\ProductBundle\ProductBundle;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 *
 * @method ProductBundle|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductBundle|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductBundle[]    findAll()
 * @method ProductBundle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductBundleRepository extends EntityRepository
{

    /**
     * @return ProductBundle[] Returns an array of ProductBundle objects
     */
    public function findByProduct(Product $product): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.products', 'product')
            ->andWhere('product.id = :val')
            ->setParameter('val', $product->getId())
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?ProductBundle
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
