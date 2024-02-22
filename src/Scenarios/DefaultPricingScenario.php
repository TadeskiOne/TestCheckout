<?php

declare(strict_types=1);

namespace TestCheckout\Scenarios;

use TestCheckout\Components\RulesMath;
use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Entities\Definitions\CartItemsCollectionInterface;
use TestCheckout\Scenarios\Definitions\DefaultScenarioInterfaceCheckout;

class DefaultPricingScenario implements DefaultScenarioInterfaceCheckout
{
    public function __construct(private readonly RulesMath $operations)
    {
    }

    public function setCartItems(?CartItemsCollectionInterface $dataProvider): static
    {
        return $this;
    }

    public function setAvailableProductCodes(array $codes): static
    {
        return $this;
    }

    public function applyTo(CartItemInterface $cartItem, \ArrayAccess &$alreadyAppliedScenarios): float
    {
        if (
            ($alreadyAppliedScenarios->offsetExists(BOGOFScenario::class)
            && $alreadyAppliedScenarios->offsetGet(BOGOFScenario::class) === true)
            || (
                $alreadyAppliedScenarios->offsetExists(BulkPurchaseScenario::class)
                && $alreadyAppliedScenarios->offsetGet(BulkPurchaseScenario::class) === true
            )
        ) {
            $alreadyAppliedScenarios->offsetSet(static::class, false);

            return 0;
        }

        return $this->operations->round($cartItem->getPrice() * $cartItem->getQuantity());
    }
}
