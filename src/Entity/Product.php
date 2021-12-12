<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\ProductImage;
use App\Repository\ProductImageRepository;
use App\Service\TwigGlobalsService;
use App\Service\CartService;
/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Numele produsului trebuie sa fie de cel putin {{ limit }} caractere",
     *      allowEmptyString = false
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    public $category;

    /**
     * @Assert\Range(
     *      min = 1,
     *      minMessage="Pretul trebuie sa fie mai mare sau egal cu 1",
     *      notInRangeMessage = "Pretul trebuie sa fie mai mare sau egal cu 1",
     * )
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $discount;

    /**
     * @ORM\ManyToOne(targetEntity=Vendor::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendor;

    /**
     * @ORM\OneToMany(targetEntity=ProductImage::class, mappedBy="product")
     */
    public $productImages;

    /**
     * @Assert\All({
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {"image/jpeg"},
     *     mimeTypesMessage = "Please upload a valid Image"
     * ),
     * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 4000,
     *     minHeight = 200,
     *     maxHeight = 4000
     * )
     * })
     */
    public $images;

    /**
     * @ORM\OneToMany(targetEntity=CartItem::class, mappedBy="product")
     */
    private $cartItems;

    public function __construct()
    {
        $this->productImages = new ArrayCollection();
        $this->cartItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(?int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param mixed $vendor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    function __toString()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     * @return Product
     */
    public function setImages($images)
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @return Collection|CartItem[]
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    public function addCartItem(CartItem $cartItem): self
    {
        if (!$this->cartItems->contains($cartItem)) {
            $this->cartItems[] = $cartItem;
            $cartItem->setProduct($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): self
    {
        if ($this->cartItems->removeElement($cartItem)) {
            // set the owning side to null (unless already changed)
            if ($cartItem->getProduct() === $this) {
                $cartItem->setProduct(null);
            }
        }

        return $this;
    }



}
