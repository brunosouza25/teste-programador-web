<?php

namespace App\Repository;

use App\Entity\Suppliers;
use App\Entity\SuppliersProducts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuppliersProducts>
 *
 * @method SuppliersProducts|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuppliersProducts|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuppliersProducts[]    findAll()
 * @method SuppliersProducts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuppliersProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuppliersProducts::class);
    }

    public function getSuppliersFromProducts($productId)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $suppliersProducts = $queryBuilder
            ->select('s.name as supplier_name')
            ->from(SuppliersProducts::class, 'sp')
            ->innerJoin(Suppliers::class, 's', 'WITH', 's.id = sp.supplier_id')
            ->where('sp.product_id = :productId')
            ->setParameter('productId', $productId)
            ->getQuery()
            ->getArrayResult();

        return $suppliersProducts;
    }

//    /**
//     * @return SuppliersProducts[] Returns an array of SuppliersProducts objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SuppliersProducts
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
