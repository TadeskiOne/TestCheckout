<?php

declare(strict_types=1);

namespace TestCheckout;

use TestCheckout\Entities\DefaultCartItemsCollection;
use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Entities\Definitions\CartItemsCollectionInterface;

class Checkout
{
    private float $total = 0;
    private CartItemsCollectionInterface $cartItemsCollection;

    public function __construct(private readonly \ArrayObject $pricingScenarios = new \ArrayObject())
    {
        $this->cartItemsCollection = new DefaultCartItemsCollection();
    }

    public function scan(CartItemInterface $cartItem): static
    {
        $this->cartItemsCollection->append($cartItem);

        return $this;
    }

    public function total(): float
    {
        if ($this->pricingScenarios->count() !== 0) {
            foreach ($this->pricingScenarios as $scenario) {
                $scenario->setCartItems($this->cartItemsCollection)->apply();
            }
        }

        foreach ($this->cartItemsCollection as $cartItem) {
            $this->total += $cartItem->getPrice();
        }

        return $this->total;
    }
}
