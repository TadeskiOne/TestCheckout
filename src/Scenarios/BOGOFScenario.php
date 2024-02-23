<?php

declare(strict_types=1);

namespace TestCheckout\Scenarios;

use TestCheckout\Entities\ReducingAmountType;
use TestCheckout\Entities\ReducingOperationType;
use TestCheckout\Rules\SimpleChangePriceRule;

class BOGOFScenario extends AbstractDiscountScenario
{
    public function apply(): bool
    {
        $setDiscount = false;

        foreach ($this->cartItems as $cartItem) {
            if (!in_array($cartItem->getCode(), $this->availableProductCodes, true)) {
                continue;
            }

            if (!$setDiscount) {
                $setDiscount = true;

                continue;
            }

            $cartItem->setPrice(
                $this->operations->round(
                    $this->collector->collectRule(SimpleChangePriceRule::class)
                        ->setAmount(100)
                        ->setAmountType(ReducingAmountType::percentage)
                        ->setOperationType(ReducingOperationType::discount)
                        ->applyTo($cartItem)
                )
            );

            $setDiscount = false;
        }

        return true;
    }
}
