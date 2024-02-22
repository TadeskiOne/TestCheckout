<?php

declare(strict_types=1);

namespace TestCheckout\Scenarios;

use TestCheckout\Components\RulesCollectorInterface;
use TestCheckout\Components\RulesMath;
use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Entities\ReducingAmountType;
use TestCheckout\Entities\ReducingOperationType;
use TestCheckout\Rules\ChangePriceFromQtyRule;

class BulkPurchaseScenario extends AbstractDiscountScenario
{
    public function __construct(
        RulesCollectorInterface $collector,
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
            $alreadyAppliedScenarios->offsetExists(BOGOFScenario::class)
            && $alreadyAppliedScenarios->offsetGet(BOGOFScenario::class) === true
        ) {
            $alreadyAppliedScenarios->offsetSet(static::class, false);

            return 0;
        }

        $alreadyAppliedScenarios->offsetSet(static::class, true);

        return $this->operations->round(
            $this->collector->collectRule(ChangePriceFromQtyRule::class)
            ->setAmount(4.50)
            ->setAmountType(ReducingAmountType::amount)
            ->setOperationType(ReducingOperationType::replacement)
            ->setOptions(replaceFromQty: 3)
            ->applyTo($cartItem) * $cartItem->getQuantity()
        );
    }
}
