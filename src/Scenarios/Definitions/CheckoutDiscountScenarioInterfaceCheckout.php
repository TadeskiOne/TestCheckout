<?php

declare(strict_types=1);

namespace TestCheckout\Scenarios\Definitions;

use TestCheckout\Entities\Definitions\CartItemInterface;

interface CheckoutDiscountScenarioInterfaceCheckout extends CheckoutPricingScenarioInterface
{
    public function setAvailableProductCodes(array $codes): static;

    public function applyTo(CartItemInterface $cartItem, \ArrayAccess &$alreadyAppliedScenarios): float;
}
