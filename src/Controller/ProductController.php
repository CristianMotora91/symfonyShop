<?php

namespace App\Controller;

use App\Form\ProductType;
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
use App\Entity\ProductImage;
use App\Service\CartService;
use App\Repository\ProductImageRepository;

/**
 * @Route("/product")
 */

class ProductController extends AbstractController
{
    /**
     * @Route("/view/{product}", name="product")
     */
    public function view(Product $product, ProductRepository $productRepository) : Response
    {
        return $this->render('default/category.html.twig',['product'=>$product, 'products'=>$productRepository->findAll()]);
    }
    /**
     * @Route("/create", name="product_form")
     */
    public function create(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $productForm = $this->createForm(ProductType::class, $product);

        $productForm->handleRequest($request);
        if ($productForm->isSubmitted() && $productForm->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $imageFiles = $productForm->get('images')->getData();
            foreach ($imageFiles as $imageFile){
                $imageFile->move('/var/www/html/national02/cristianm/symfonyShop/public/images', $imageFile->getClientOriginalName());
                $productImage = new ProductImage();
                $productImage->setImage($imageFile->getClientOriginalName());
                $productImage->setProduct($product);
                $entityManager->persist($productImage);
            }

            $entityManager->persist($product);
            $entityManager->flush();
        }

        return $this->render('product/index.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }

    /**
     * @Route("/edit/{product}", name="product_edit")
     */
    public function edit(Product $product, Request $request): Response
    {
        $productForm = $this->createForm(ProductType::class, $product);

        $productForm->handleRequest($request);
        if ($productForm->isSubmitted() && $productForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $imageFiles = $productForm->get('images')->getData();
            foreach ($imageFiles as $imageFile){
                $imageFile->move('/var/www/html/national02/cristianm/symfonyShop/public/images', $imageFile->getClientOriginalName());
                $productImage = new ProductImage();
                $productImage->setImage($imageFile->getClientOriginalName());
                $productImage->setProduct($product);
                $em->persist($productImage);
            }

            $em->persist($product);
            $em->flush();
        }

        return $this->render('product/index.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }

    public function product(Product $product,ProductRepository $productRepository,CategoryRepository $categoryRepository, VendorRepository $vendorRepository): Response
    {
        return $this->render('product/index.html.twig',
            [
                'categories'=>$categoryRepository->findAll(),
                'vendors'=>$vendorRepository->findAll(),
                'product'=>$product
            ]);
    }



}
