<?php

declare(strict_types=1);

namespace TestCheckout\Rules;

use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Rules\Definitions\ReduceAmountRuleInterface;

class SimpleChangePriceRule extends AbstractRule implements ReduceAmountRuleInterface
{
    public function applyTo(CartItemInterface $item): float
    {
        return $this->operations->round($this->operations->applyOperation($item->getPrice(), $this));
    }
}
