<?php

namespace App\Controller;

use App\Repository\ProductBundle\ProductBundleRepository;
use Doctrine\Persistence\ObjectManager;
use Sylius\Component\Channel\Context\ChannelNotFoundException;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Core\Context\ShopperContextInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\Component\Order\Context\CartNotFoundException;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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

        $order = $this->getCurrentCart();
        $channel = $this->getCurrentChannel();

        if ($order && $channel) {
            $orderItems = $order->getItems();
            foreach ($bundle->getProducts() as $product) {
                $productId = (int) $product->getVariants()->first()->getId();
                /** @var ProductVariantInterface $variant */
                $variant = $this->productVariantRepository->find($productId);

                /** @var OrderItemInterface $orderItem */
                $orderItem = $this->orderItemFactory->createNew();
                $variant->setShippingRequired(false);
                $orderItem->setVariant($variant);
                $price = $variant->getChannelPricingForChannel($channel)->getPrice();
                $orderItem->setUnitPrice($price);

                $targetQuantity = 1;

                foreach ($orderItems as $oi) {
                    if ($oi->getVariant()->getId() == $productId) {
                        $orderItem = $oi;
                        $targetQuantity = $oi->getQuantity() + 1;
                        break;
                    }
                }

                $this->orderItemQuantityModifier->modify($orderItem, $targetQuantity);

                if ($targetQuantity == 1) {
                    $order->addItem($orderItem);
                }
            }

            $order->setChannel($channel);
            $order->setLocaleCode($this->shopperContext->getLocaleCode());
            $order->setCurrencyCode($this->shopperContext->getCurrencyCode());

            $this->orderManager->persist($order);
            $this->orderManager->flush();
        }

        $cartPage = $this->router->generate('sylius_shop_cart_summary');
        return new RedirectResponse($cartPage);
    }

    private function getCurrentCart(): ?OrderInterface
    {
        try {
            $cart = $this->cartContext->getCart();
        } catch (CartNotFoundException) {
            return null;
        }

        if (!$cart instanceof OrderInterface) {
            return null;
        }

        return $cart;
    }

    private function getCurrentChannel(): ?ChannelInterface
    {
        try {
            $channel = $this->shopperContext->getChannel();
        } catch (ChannelNotFoundException) {
            return null;
        }

        if (!$channel instanceof ChannelInterface) {
            return null;
        }

        return $channel;
    }
}
