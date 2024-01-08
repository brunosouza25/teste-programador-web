<?php

namespace App\Service;

use App\Repository\CartRepository;

class CartService
{
    private $cartRepository;
    private $productService;
    private $suppliersService;

    public function __construct(CartRepository $cartRepository, ProductsService $productService, SuppliersService $suppliersService)
    {
        $this->cartRepository = $cartRepository;
        $this->productService = $productService;
        $this->suppliersService = $suppliersService;
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
        $cartProducts = $this->cartRepository->getProductsInCart();

        if (is_null($cartProducts)) {
            return ['info' => 'cart empty', 'code' => 404];
        }

        $cartProducts = $this->cartRepository->getProductsInCart();

        $newArrayCartProducts = [];

        foreach ($cartProducts as $cartProduct) {
            $cartProduct['suppliers'] = $this->suppliersService->getSuppliersFromProducts($cartProduct['product_id']);
            $newArrayCartProducts[] = $cartProduct;
        }

        return ['info' => 'success', 'code' => '200', 'products' => $newArrayCartProducts];
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