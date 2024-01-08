<?php

namespace App\Repository;

use App\Entity\OrderProducts;
use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Orders>
 *
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orders::class);
    }

    public function newOrder($orderInfo)
    {
        $en = $this->getEntityManager();

        $order = new Orders();
        $order->setCep($orderInfo->cep);
        $order->setDeliveryCity($orderInfo->city);
        $order->setDeliveryNeighborhood($orderInfo->neighborhood);
        $order->setDeliveryStreet($orderInfo->street);
        $order->setDeliveryUf($orderInfo->uf);
        $order->setDeliveryObservations($orderInfo->observation);
        $order->setDeliveryNumber($orderInfo->number);

        $en->persist($order);
        $en->flush();

        return $order;
    }

    public function addProductToOrder($product, $orderId)
    {
        $en = $this->getEntityManager();

        $newOrderProduct = new OrderProducts();

        $newOrderProduct->setProductId($product->product_id);
        $newOrderProduct->setQuantity($product->quantity);
        $newOrderProduct->setPrice($product->price);
        $newOrderProduct->setOrderId($orderId);

        $en->persist($newOrderProduct);
        $en->flush();

    }

//    /**
//     * @return Orders[] Returns an array of Orders objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Orders
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
