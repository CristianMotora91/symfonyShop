<?php
namespace App\Service;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\CartItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Exception;

class CartService
{
    /** @var  Cart */
    private $cart;

    /** @var  SessionInterface */
    private $session;

    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * CartService constructor.
     * @param SessionInterface $session
     * @param $entityManager
     */
    public function __construct(SessionInterface $session, $entityManager)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
        $this->cart = $this->getCurrentCart();
    }

    /**
     * @return Cart
     */
    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function add(Product $product, $quantity=1)
    {
        $cartItem = $this->getCartItemForProduct($product);
        $cartItem->setQuantity($quantity);
        $cartItem->setCart($this->cart);
        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();
    }


    public function delete(Product $product)
    {
        $cartItem = $this->getCartItemForProduct($product);
        $this->entityManager->remove($cartItem);
        $this->entityManager->flush();

    }

    public function empty()
    {
        foreach ($this->cart->getCartItems() as $cartItem){
            $this->entityManager->remove($cartItem);
        }
        $this->entityManager->flush();
    }

    private function getCartItemForProduct(Product $product):CartItem
    {
        foreach ($this->cart->getCartItems() as $cartItem){
            if ($cartItem->getProduct()->getId() == $product->getId()){
                return $cartItem;
            }
        }
        $cartItem = new CartItem();
        $cartItem->setProduct($product);

        return $cartItem;
    }

    private function getCurrentCart()
    {
        if($this->session->has('cart_id')){
            $this->entityManager->getRepository(Cart::class)->find($this->session->get('cart_id'));
        } else {
            $this->cart = new Cart();
            $this->entityManager->persist($this->cart);
            $this->entityManager->flush();

            $this->session->set('cart_id', $this->cart->getId());
        }
    }
}