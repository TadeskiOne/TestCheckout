<?php

declare(strict_types=1);

namespace TestCheckout\Scenarios;

use TestCheckout\Entities\ReducingAmountType;
use TestCheckout\Entities\ReducingOperationType;
use TestCheckout\Rules\SimpleChangePriceRule;

class BulkPurchaseScenario extends AbstractDiscountScenario
{
    public function apply(): bool
    {
        $countSameProductsInCart = 0;

        foreach ($this->cartItems as $cartItem) {
            if (!in_array($cartItem->getCode(), $this->availableProductCodes, true)) {
                continue;
            }

            ++$countSameProductsInCart;
        }

        if ($countSameProductsInCart < 3) {
            return false;
        }

        foreach ($this->cartItems as $cartItem) {
            if (!in_array($cartItem->getCode(), $this->availableProductCodes, true)) {
                continue;
            }

            $cartItem->setPrice(
                $this->operations->round(
                    $this->collector->collectRule(SimpleChangePriceRule::class)
                        ->setAmount(4.50)
                        ->setAmountType(ReducingAmountType::amount)
                        ->setOperationType(ReducingOperationType::replacement)
                        ->applyTo($cartItem)
                )
            );
        }

        return true;
    }
}
