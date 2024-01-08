<?php

namespace App\Controller;

use App\Service\OrdersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $ordersService;

    public function __construct(OrdersService $ordersService)
    {
        $this->ordersService = $ordersService;
    }

    #[Route('/order', name: 'app_order')]
    public function index(): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    #[Route('/finish_order', name: 'finish_order')]
    public function finishOrder(Request $request): Response
    {
        $orderInfo = $request->get('orderInfo');


        $response = $this->ordersService->finishOrder($orderInfo);
        return new JsonResponse($response);
    }


}
