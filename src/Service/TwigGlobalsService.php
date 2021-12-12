<?php

namespace App\Service;

use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Repository\VendorRepository;
use App\Entity\Vendor;
use App\Repository\ProductRepository;
use App\Entity\Product;
use Symfony\Flex\Response;

class TwigGlobalsService
{
    /** @var  @var CategoryRepository */

    private $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */

    public  function __construct(CategoryRepository $categoryRepository, VendorRepository $vendorRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->vendorRepository = $vendorRepository;
    }

    public function getMenuCategories()
    {
        return $this->categoryRepository->findAll();
    }

    public function getMenuVendors()
    {
        return $this->vendorRepository->findAll();
    }

    public function category(Category $category, CategoryRepository $categoryRepository) : Response
    {
        $products = $category->getProducts();
        return $this->render('default/category.html.twig',['category'=>$category, 'categories'=>$categoryRepository->findAll()]);
    }

    public function product(Product $product, ProductRepository $productRepository) : Response
    {
        $product = $productRepository->findAll();
        $products = $productRepository->findAll();
    }
}