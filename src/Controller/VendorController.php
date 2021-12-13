<?php

namespace App\Controller;

use App\Entity\Vendor;
use App\Repository\VendorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Entity\Product;

/**
 * @Route("/vendor")
 */

class VendorController extends AbstractController
{
    /**
     * @Route("/view/{vendor}", name="vendor")
     */
    public function view(ProductRepository $productRepository, Product $product, Vendor $vendor, Request $request) : Response
    {
        return $this->render('vendor\index.html.twig',
        [
            'vendor'=>$vendor,
            'product'=>$product
        ]);
    }
}
