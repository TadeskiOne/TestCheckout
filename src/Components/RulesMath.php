<?php

declare(strict_types=1);

namespace TestCheckout\Components;

use TestCheckout\Entities\ReducingAmountType;
use TestCheckout\Entities\ReducingOperationType;
use TestCheckout\Rules\Definitions\RuleInterface;

class RulesMath
{
    public function applyOperation(float $amount, RuleInterface $rule): float
    {
        return match ($rule->getOperationType()) {
            ReducingOperationType::discount => $this->discount($amount, $rule),
            ReducingOperationType::replacement => $this->replacement($amount, $rule),
        };
    }

    public function discount(float $amount, RuleInterface $rule): float
    {
        return match ($rule->getAmountType()) {
            ReducingAmountType::percentage => $amount - ($amount * ($rule->getAmount() / 100)),
            ReducingAmountType::amount => $amount - $rule->getAmount()
        };
    }

    public function replacement(float $amount, RuleInterface $rule): float
    {
        return match ($rule->getAmountType()) {
            ReducingAmountType::percentage => $amount * ($rule->getAmount() / 100),
            ReducingAmountType::amount => $rule->getAmount()
        };
    }

    public function round(float $amount): float
    {
        return round($amount * 100) / 100;
    }
}
