<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\CartProducts;
use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cart>
 *
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function checkCartCreated()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $cart = $queryBuilder
            ->select('c')
            ->from(Cart::class, 'c')
            ->where('c.status = 0')
            ->getQuery()
            ->getArrayResult();

        if (empty($cart)) {
            return null;
        }

        return $cart[0]['id'];
    }

    public function getProductsInCart()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $cart = $queryBuilder
            ->select('c')
            ->from(Cart::class, 'c')
            ->where('c.status = 0')
            ->getQuery()
            ->getArrayResult();

        if (empty($cart)) {
            return null;
        }

        $cartProducts = $queryBuilder
            ->select('cp.quantity, cp.id', 'p.name, p.price, p.id as product_id')
            ->from(CartProducts::class, 'cp')
            ->innerJoin(Products::class, 'p')
            ->where('cp.cart_id = :cartId')
            ->andWhere('cp.product_id = p.id')
            ->setParameter('cartId', $cart[0]['id'])
            ->getQuery()
            ->getArrayResult();

        if (empty($cartProducts)) {
            return null;
        }
        return $cartProducts;
    }

    public function createCart()
    {
        $en = $this->getEntityManager();

        $cart = new Cart();
        $cart->setStatus(0);

        $en->persist($cart);
        $en->flush();
        return $cart->getId();
    }

    public function addNewProductToCart($product, $cartId)
    {
        $en = $this->getEntityManager();

        $cartProduct = new CartProducts();

        $cartProduct->setCartId($cartId);
        $cartProduct->setProductId($product->id);
        $cartProduct->setQuantity(1);

        $en->persist($cartProduct);
        $en->flush();

    }

    public function deleteProductFromCart($productId)
    {
        $en = $this->getEntityManager();

        $cartProduct = $en->getRepository(CartProducts::class)->find($productId);

        $en->remove($cartProduct);

        $en->flush();
    }

    public function getTotalCart()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $cart = $queryBuilder
            ->select('c')
            ->from(Cart::class, 'c')
            ->where('c.status = 0')
            ->getQuery()
            ->getArrayResult();

        if (empty($cart)) {
            return null;
        }

        $total = $queryBuilder
            ->select('SUM(p.price) as total')
            ->from(CartProducts::class, 'cp')
            ->innerJoin(Products::class, 'p')
            ->where('cp.cart_id = :cartId')
            ->andWhere('cp.product_id = p.id')
            ->setParameter('cartId', $cart[0]['id'])
            ->getQuery()
            ->getArrayResult()[0];

        return $total;
    }

//    /**
//     * @return Cart[] Returns an array of Cart objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cart
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
