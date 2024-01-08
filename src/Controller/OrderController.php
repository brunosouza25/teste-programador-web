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

    #[Route('/orders', name: 'orders')]
    public function index(): Response
    {
        return $this->render('orders/index.html.twig', [
            'controller_name' => 'Pedidos',
        ]);
    }
    #[Route('/get_orders', name: 'get_orders')]
    public function getOrders(): Response
    {
        $orders = $this->ordersService->getOrders();
        return new JsonResponse($orders);
    }

    #[Route('/order_info', name: 'order_info')]
    public function orderInfo(Request $request): Response
    {
        $orderId = $request->get('orderId');
        return $this->render('orders/orderInfo.html.twig', [
            'controller_name' => 'Pedidos',
            'orderId' => $orderId
        ]);
    }

    #[Route('/get_order_info', name: 'get_order_info')]
    public function getOrderInfo(Request $request): Response
    {
        $orderId = $request->get('orderId');

        $orderProducts = $this->ordersService->getOrderInfo($orderId);

        return new JsonResponse($orderProducts);
    }

    #[Route('/finish_order', name: 'finish_order')]
    public function finishOrder(Request $request): Response
    {
        $orderInfo = $request->get('orderInfo');

        $response = $this->ordersService->finishOrder($orderInfo);
        return new JsonResponse($response);
    }


}
