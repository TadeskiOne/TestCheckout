<?php

declare(strict_types=1);

namespace TestCheckout\Rules\Definitions;

use TestCheckout\Entities\Definitions\CartItemInterface;

interface ReduceAmountRuleInterface extends RuleInterface
{
    public function applyTo(CartItemInterface $item): float;
}
