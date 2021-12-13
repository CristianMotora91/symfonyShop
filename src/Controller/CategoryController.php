<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;

/**
 * @Route("/category")
 */

class CategoryController extends AbstractController

{
    /**
     * @Route("/view/{category}", name="category")
     */

    public function view(ProductRepository $productRepository,Product $product, Category $category, Request $request) : Response
    {
        return $this->render('default/category.html.twig',
            [
                'product'=>$product,
                'category'=>$category
            ]);
    }

    /**
     * @Route("/create", name="category_form")
     */
    public function create(Request $request): Response
    {
        $category = new Category();
        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($request);
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        }

        return $this->render('category/index.html.twig', [
            'categoryForm' => $categoryForm->createView()
        ]);
    }

    /**
     * @Route("/edit/{category}", name="category_edit")
     */
    public function edit(Category $category, Request $request): Response
    {
        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($request);
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        }

        return $this->render('category/index.html.twig', [
            'categoryForm' => $categoryForm->createView()
        ]);
    }
}
