<?php

namespace App\Service;

use App\Repository\CartRepository;

class CartService
{
    private $cartRepository;
    private $productService;

    public function __construct(CartRepository $cartRepository, ProductsService $productService)
    {
        $this->cartRepository = $cartRepository;
        $this->productService = $productService;
    }

    public function addNewProductToCart($productSearch)
    {
        $product = $this->productService->findProduct($productSearch);

        if (is_null($product)) {
            return ['info' => 'product not found', 'code' => 404];
        }

        $cartId = $this->checkCartCreated(true);

        $this->cartRepository->addNewProductToCart($product, $cartId);

        return ['info' => 'success', 'code' => 200];
    }

    public function checkCartCreated($create)
    {
        $cartId = $this->cartRepository->checkCartCreated();

        if (is_null($cartId) && $create) {
            $cartId = $this->cartRepository->createCart();

            return $cartId;
        }
        return $cartId;


    }

    public function getProductsInCart()
    {
        return $this->cartRepository->getProductsInCart();
    }

    public function deleteProductFromCart($productId)
    {
        $this->cartRepository->deleteProductFromCart($productId);
    }

    public function getTotalCart()
    {
        $total = $this->cartRepository->getTotalCart();

        if (is_null($total)) {
            return 0;
        }

        return $total['total'];
    }
}