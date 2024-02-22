<?php

declare(strict_types=1);

namespace TestCheckout\Scenarios\Definitions;

use TestCheckout\Entities\Definitions\CartItemsCollectionInterface;

interface CheckoutPricingScenarioInterface
{
    public function setCartItems(CartItemsCollectionInterface $dataProvider): static;
}
