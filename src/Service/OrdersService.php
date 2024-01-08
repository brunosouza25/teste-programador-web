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