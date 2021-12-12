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

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('default/index.html.twig',['categories'=>$categoryRepository->findAll()]);
    }


    /**
     * @Route("/vendor/{vendor}", name="vendor")
     */
    public function vendor(Vendor $vendor, VendorRepository $vendorRepository, CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        return $this->render('vendor/index.html.twig',
            [   'vendor'=>$vendor,
                'vendors'=>$vendorRepository->findAll(),
                'categories'=> $categoryRepository->findAll(),
                'products'=>$productRepository->findAll()
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
