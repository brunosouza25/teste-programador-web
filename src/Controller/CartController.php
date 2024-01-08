<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    #[Route('/add_product_to_cart', name: 'add_product_to_cart')]
    public function addProductToCart(Request $request): Response
    {
        $product = $request->get('productSearch');

        $response = $this->cartService->addNewProductToCart($product);

        return new JsonResponse($response);
    }

    #[Route('/get_products_in_cart', name: 'get_products_in_cart')]
    public function getProductsInCart(): Response
    {
        $products = $this->cartService->getProductsInCart();

        return new JsonResponse($products);
    }
    #[Route('/delete_product_from_cart', name: 'delete_product_from_cart')]
    public function deleteProductFromCart(Request $request): Response
    {
        $productId = $request->get('productId');

        $this->cartService->deleteProductFromCart($productId);

        return new Response();
    }
    #[Route('/get_total_cart', name: 'get_total_cart')]
    public function getTotalCart(): Response
    {
        $total = $this->cartService->getTotalCart();

        return new JsonResponse($total);
    }

}
