<?php

declare(strict_types=1);

namespace TestCheckout\Rules;

use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Rules\Definitions\ReduceAmountRuleInterface;

class ChangePriceFromQtyRule extends AbstractRule implements ReduceAmountRuleInterface
{
    private int $replaceFromQty = 0;

    public function getOptionsNames(): array
    {
        return ['replaceFromQty'];
    }

    public function setOptions(...$options): static
    {
        foreach ($options as $name => $value) {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }

        return $this;
    }

    public function applyTo(CartItemInterface $item): float
    {
        return $item->getQuantity() >= $this->replaceFromQty
            ? $this->operations->round($this->operations->applyOperation($item->getPrice(), $this))
            : $item->getPrice();
    }
}
