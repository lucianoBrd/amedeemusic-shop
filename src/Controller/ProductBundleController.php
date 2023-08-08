<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProductBundle\ProductBundleRepository;
use App\Form\Type\ProductBundle\AddProductBundleToCartType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductBundleController extends AbstractController
{
    public function __construct(
        private ProductBundleRepository $productBundleRepository,
    ) {}
    
    public function index(string $bundleName): Response
    {
        $bundle = $this->productBundleRepository->findOneBy(['name' => $bundleName]);

        $form = $this->createForm(AddProductBundleToCartType::class, null, [
            'bundle' => $bundle,
        ]);
        
        return $this->render('page/Homepage/ProductBundle/_products.html.twig', [
            'bundle' => $bundle,
            'form' => $form->createView()
        ]);
    }
}