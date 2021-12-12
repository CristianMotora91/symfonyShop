<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', ['cart' => $cartService->getCart()]);
    }

    /**
     * @Route("/cart/{product}", name="cart_delete")
     */

    public function delete(Product $product, CartService $cartService): Response
    {
        $cartService->delete($product);
        return $this->redirectToRoute('cart');
    }
}
