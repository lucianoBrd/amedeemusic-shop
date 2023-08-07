<?php

namespace App\Controller;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use App\Repository\ProductBundle\ProductBundleRepository;
use Sylius\Component\Core\Context\ShopperContextInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;

class ProductBundleAction extends AbstractController
{
    public function __construct(
        private ProductVariantRepositoryInterface $productVariantRepository,
        private FactoryInterface $orderItemFactory,
        private OrderItemQuantityModifierInterface $orderItemQuantityModifier,
        private ShopperContextInterface $shopperContext,
        private ObjectManager $orderManager,
        private UrlGeneratorInterface $router,
        private CartContextInterface $cartContext
    ) {}

    public function __invoke(Request $request, ProductBundleRepository $productBundleRepository): Response
    {
        $bundleName = $request->attributes->get('name');
        $bundle = $productBundleRepository->findOneBy(['name' => $bundleName]);

        /** @var OrderInterface $order */
        $order = $this->getCurrentCart();

        $channel = $this->shopperContext->getChannel();
        foreach ($bundle->getProducts() as $product)
        {
            $productId = (int) $product->getVariants()->first()->getId();
            /** @var ProductVariantInterface $variant */
            $variant = $this->productVariantRepository->find($productId);

            /** @var OrderItemInterface $orderItem */
            $orderItem = $this->orderItemFactory->createNew();
            $variant->setShippingRequired(false);
            $orderItem->setVariant($variant);
            $price = $variant->getChannelPricingForChannel($channel)->getPrice();
            $orderItem->setUnitPrice($price);

            $this->orderItemQuantityModifier->modify($orderItem, 1);

            $order->addItem($orderItem);
        }

        $order->setChannel($channel);
        $order->setLocaleCode($this->shopperContext->getLocaleCode());
        $order->setCurrencyCode($this->shopperContext->getCurrencyCode());

        $this->orderManager->persist($order);
        $this->orderManager->flush();

        $cartPage = $this->router->generate('sylius_shop_cart_summary');
        return new RedirectResponse($cartPage);
    }

    protected function getCurrentCart(): OrderInterface
    {
        return $this->cartContext->getCart();
    }
}