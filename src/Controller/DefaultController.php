<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Vendor;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\VendorRepository;
use PharIo\Manifest\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Config\Exception;
use App\Service\CartService;
use App\Entity\Cart;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ProductRepository $productRepository,CategoryRepository $categoryRepository, VendorRepository $vendorRepository, CartService $cartService): Response
    {
        return $this->render('default/index.html.twig',
            [
                'categories'=>$categoryRepository->findAll(),
                'vendors'=>$vendorRepository->findAll(),
                'productsNewest'=>$productRepository->findBy([],['id'=>'DESC'],4),
                'productsCoins'=>$productRepository->findBy(['category'=>10], ['id'=>'DESC'], 4),
                'productsModels'=>$productRepository->findBy(['category'=>11], ['id'=>'DESC'], 4),
                'productsFigures'=>$productRepository->findBy(['category'=>12], ['id'=>'DESC'], 4),
                'cart'=>$cartService
            ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin", name="admin")
     */
    public function admin(CategoryRepository $categoryRepository, VendorRepository $vendorRepository, ProductRepository $productRepository): Response
    {
        return $this->render('default/adminPage.html.twig',
            [
                'categories'=>$categoryRepository->findAll(),
                'vendors'=>$vendorRepository->findAll(),
                'products'=>$productRepository->findAll()
            ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(CategoryRepository $categoryRepository, VendorRepository $vendorRepository, ProductRepository $productRepository): Response
    {
        return $this->render('default/contact.html.twig',
            [
                'categories'=>$categoryRepository->findAll(),
                'vendors'=>$vendorRepository->findAll(),
                'products'=>$productRepository->findAll()
            ]);
    }


}
