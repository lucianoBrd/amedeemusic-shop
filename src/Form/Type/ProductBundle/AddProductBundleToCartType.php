<?php

declare(strict_types=1);

namespace App\Form\Type\ProductBundle;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\ProductBundle\ProductBundleInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sylius\Bundle\CoreBundle\Form\Type\Order\AddToCartType;

final class AddProductBundleToCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $bundle = $options['bundle'];

        foreach ($bundle->getProducts() as $product) {
            $builder->add((string) $product->getId(), AddToCartType::class, 
            ['product' => $product]
        );
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefined([
                'bundle',
            ])
            ->setAllowedTypes('bundle', ProductBundleInterface::class)
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'app_add_product_bundle_to_cart';
    }
}