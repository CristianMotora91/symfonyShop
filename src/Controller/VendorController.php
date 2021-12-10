<?php

namespace App\Controller;

use App\Entity\Vendor;
use App\Repository\VendorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VendorController extends AbstractController
{
    /**
     * @Route("/", name="vendor_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('vendor/index.html.twig', [
            'vendors' => $vendorRepository->findAll(),
            'categories'=>$categoryRepository->findAll()
        ]);
    }

    public function vendor(Vendor $vendor, VendorRepository $vendorRepository) : Response
    {
        $products = $vendor->getProducts();
    }
}
