<?php

namespace App\Controller;

use App\Service\RandomService;
use App\Entity\Product\Product;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProductBundle\ProductBundleRepository;
use App\Form\Type\ProductBundle\AddProductBundleToCartType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductBundleController extends AbstractController
{
    public function __construct(
        private ProductBundleRepository $productBundleRepository,
        private RandomService $randomService,
    ) {}
    
    public function homepage(): Response
    {
        $bundles = $this->productBundleRepository->findBy([], ['id' => 'DESC']);
        $bundles = $this->randomService->getRandom($bundles, 1);
        $bundle = count($bundles) > 0 ? $bundles[0] : null;

        $form = $this->createForm(AddProductBundleToCartType::class, null, [
            'bundle' => $bundle,
        ]);
        
        return $this->render('page/ProductBundle/_products.html.twig', [
            'bundle' => $bundle,
            'form' => $form->createView()
        ]);
    }

    public function product(Product $product): Response
    {
        $bundles = $this->productBundleRepository->findByProduct($product);
        $bundles = $this->randomService->getRandom($bundles, 1);
        $bundle = count($bundles) > 0 ? $bundles[0] : null;

        $form = $this->createForm(AddProductBundleToCartType::class, null, [
            'bundle' => $bundle,
        ]);
        
        return $this->render('page/ProductBundle/_products.html.twig', [
            'bundle' => $bundle,
            'form' => $form->createView()
        ]);
    }
}