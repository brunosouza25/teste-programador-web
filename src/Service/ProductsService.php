<?php

namespace App\Service;

use App\Repository\ProductsRepository;

class ProductsService
{
    private $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function findProduct($productSearch)
    {
        return $this->productsRepository->findProduct($productSearch);
    }
}