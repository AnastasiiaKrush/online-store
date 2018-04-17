<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Product;

class LayoutController extends Controller
{
    public function stockProducts()
    {
        $stockProducts = $this->getDoctrine()->getRepository(Product::class)->findAllStockProducts();

        return $this->render(
            'layout/carousel.html.twig',
            [
                'stock_products' => $stockProducts
            ]
        );
    }
}