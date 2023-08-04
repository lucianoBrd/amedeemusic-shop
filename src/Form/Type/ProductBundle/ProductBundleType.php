<?php

declare(strict_types=1);

namespace App\Form\Type\ProductBundle;

use App\Entity\Product\Product;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;

final class ProductBundleType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'sylius.ui.name'])
            ->add('products', EntityType::class, array(
                'class' => Product::class,
                'choice_label' => 'name',
                'label'        => 'Product',
                'expanded'     => true,
                'multiple'     => true,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_product_bundle';
    }
}