<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Vendor;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\VendorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    public function product(Product $product,ProductRepository $productRepository,CategoryRepository $categoryRepository, VendorRepository $vendorRepository): Response
    {
        return $this->render('default/product.html.twig',
            [
                'categories'=>$categoryRepository->findAll(),
                'vendors'=>$vendorRepository->findAll(),
                'product'=>$product

            ]);
    }



}
