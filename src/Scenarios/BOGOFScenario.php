<?php

declare(strict_types=1);

namespace TestCheckout\Scenarios;

use TestCheckout\Components\RulesCollectorInterface;
use TestCheckout\Components\RulesMath;
use TestCheckout\Entities\Definitions\CartFactoryInterface;
use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Entities\ReducingAmountType;
use TestCheckout\Entities\ReducingOperationType;
use TestCheckout\Rules\SimpleChangePriceRule;

class BOGOFScenario extends AbstractDiscountScenario
{
    public function __construct(
        RulesCollectorInterface $collector,
        private readonly CartFactoryInterface $cartFactory,
        private readonly RulesMath $operations
    ) {
        parent::__construct($collector);
    }

    public function applyTo(CartItemInterface $cartItem, \ArrayAccess &$alreadyAppliedScenarios): float
    {
        if (!in_array($cartItem->getCode(), $this->availableProductCodes, true)) {
            $alreadyAppliedScenarios->offsetSet(static::class, false);

            return 0;
        }

        if (
            $alreadyAppliedScenarios->offsetExists(BulkPurchaseScenario::class)
            && $alreadyAppliedScenarios->offsetGet(BulkPurchaseScenario::class) === true
        ) {
            $alreadyAppliedScenarios->offsetSet(static::class, false);

            return 0;
        }

        $this->cartItems->append(
            $this->cartFactory->makeItem(
                $cartItem->getCode(),
                $cartItem->getName(),
                $cartItem->getQuantity(),
                $this->collector->collectRule(SimpleChangePriceRule::class)
                    ->setAmount(100)
                    ->setAmountType(ReducingAmountType::percentage)
                    ->setOperationType(ReducingOperationType::discount)
                    ->applyTo($cartItem)
            )
        );

        $alreadyAppliedScenarios->offsetSet(static::class, true);

        return $this->operations->round($cartItem->getPrice() * $cartItem->getQuantity());
    }
}
