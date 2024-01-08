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

}
