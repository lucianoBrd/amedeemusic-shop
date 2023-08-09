<?php

namespace App\Controller;

use Webmozart\Assert\Assert;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use App\Repository\ProductBundle\ProductBundleRepository;
use Sylius\Component\Order\Context\CartNotFoundException;
use Sylius\Component\Core\Context\ShopperContextInterface;
use Sylius\Component\Channel\Context\ChannelNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
        
        $order = $this->getCurrentCart();
        $channel = $this->getCurrentChannel();

        $addProductBundleToCart = $request->request->all();
        if (isset($addProductBundleToCart['app_add_product_bundle_to_cart'])) {
            $addProductBundleToCart = $addProductBundleToCart['app_add_product_bundle_to_cart'];
        }
        
        if ($order && $channel) {
            $orderItems = $order->getItems();
            foreach ($bundle->getProducts() as $product) {
                $productId = (int) $product->getVariants()->first()->getId();

                if (isset($addProductBundleToCart[(string) $product->getId()])) {
                    $cartItem = $addProductBundleToCart[(string) $product->getId()];
                    if (isset($cartItem['cartItem']) && isset($cartItem['cartItem']['variant'])) {
                        $variants = $cartItem['cartItem']['variant'];
                        foreach ($product->getVariants() as $var) {
                            $found = true;
                            foreach ($var->getOptionValues() as $optionValue) {
                                $code = $optionValue->getCode();
                                $optionCode = $optionValue->getOptionCode();
                                $match = false;
                                foreach ($variants as $key => $value) {
                                    if ($key == $optionCode && $value == $code) {
                                        $match = true;
                                        break;
                                    }
                                }
                                if (!$match) {
                                    $found = false;
                                    break;
                                }
                            }
                            if ($found == true) {
                                $productId = $var->getId();
                                break;
                            }
                        }
                    }
                }
                
                /** @var ProductVariantInterface $variant */
                $variant = $this->productVariantRepository->find($productId);

                Assert::notNull($variant);

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
