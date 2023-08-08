<?php

namespace App\Entity\ProductBundle;

use App\Entity\Product\Product;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ProductBundleInterface extends ResourceInterface
{
    public function getName(): ?string;

    public function setName(string $name): static;

    public function getProducts(): Collection;

    public function addProduct(Product $product): static;

    public function removeProduct(Product $product): static;
}