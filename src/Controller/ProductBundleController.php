<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProductBundle\ProductBundleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductBundleController extends AbstractController
{
    public function __construct(
        private ProductBundleRepository $productBundleRepository,
    ) {}
    
    public function index(string $bundleName): Response
    {
        $bundle = $this->productBundleRepository->findOneBy(['name' => $bundleName]);
        
        return $this->render('page/Homepage/ProductBundle/_products.html.twig', [
            'bundle' => $bundle,
        ]);
    }
}