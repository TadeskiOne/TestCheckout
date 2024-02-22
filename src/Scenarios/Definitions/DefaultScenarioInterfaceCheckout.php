<?php

declare(strict_types=1);

namespace TestCheckout\Scenarios\Definitions;

use TestCheckout\Entities\Definitions\CartItemInterface;

interface DefaultScenarioInterfaceCheckout extends CheckoutPricingScenarioInterface
{
    public function applyTo(CartItemInterface $cartItem, \ArrayAccess &$alreadyAppliedScenarios): float;
}
