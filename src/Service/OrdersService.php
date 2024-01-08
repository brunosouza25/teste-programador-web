<?php

namespace App\Service;


use App\Entity\OrderProducts;
use App\Repository\OrdersRepository;

class OrdersService
{

    private $orderRepository;
    private $cartService;
    public function __construct(OrdersRepository $orderRepository, CartService $cartService)
    {
        $this->orderRepository = $orderRepository;
        $this->cartService = $cartService;
    }

    public function getOrders($orderId = null)
    {
        $orders = $this->orderRepository->getOrders($orderId);
        return $orders;
    }
    public function getOrderInfo($orderId)
    {
        $order = new \stdClass();
        $orderProducts = $this->getOrderProducts($orderId);
        $orderInfo = $this->orderRepository->getOrders($orderId);

        $order->products = $orderProducts->products;
        $order->orderInfo = $orderInfo;

        return $order;
    }

    public function getOrderProducts($orderId)
    {
        $orders = $this->orderRepository->getOrderProducts($orderId);
        return $orders;
    }

    public function finishOrder($orderInfo)
    {
        $cartProducts = $this->cartService->getProductsInCart();

        if (is_null($cartProducts)) {
            return ['info' => 'cart empty', 'code' => 404];
        }

        $order = $this->orderRepository->newOrder((object)$orderInfo);

        foreach ($cartProducts as $cartProduct) {
            $cartProduct = (object)$cartProduct;
            $this->orderRepository->addProductToOrder($cartProduct, $order->getId());
            $this->cartService->deleteProductFromCart($cartProduct->id);
        }

        return ['info' => 'success', 'code' => 200];
    }


}