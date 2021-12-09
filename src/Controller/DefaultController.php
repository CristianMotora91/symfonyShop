<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use PharIo\Manifest\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/category/{category}", name="category")
     */

    public function category(Category $category, CategoryRepository $categoryRepository) : Response
    {
        $products = $category->getProducts();
        return $this->render('default/category.html.twig',['category'=>$category, 'categories'=>$categoryRepository->findAll()]);
    }
}
