<?php

namespace App\Service;



use App\Repository\SuppliersProductsRepository;

class SuppliersService
{
    private $suppliersProductsRepository;

    public function __construct(SuppliersProductsRepository $suppliersProductsRepository)
    {
        $this->suppliersProductsRepository = $suppliersProductsRepository;
    }

    public function getSuppliersFromProducts($productId)
    {
        $suppliers = $this->suppliersProductsRepository->getSuppliersFromProducts($productId);
        $newArraySupliers = [];
        foreach ($suppliers as $supplier) {
            $newArraySupliers[] = $supplier['supplier_name'];
        }
        return (implode(', ',$newArraySupliers));
    }
}