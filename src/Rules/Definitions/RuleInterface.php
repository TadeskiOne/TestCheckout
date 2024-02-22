<?php

declare(strict_types=1);

namespace TestCheckout\Rules\Definitions;

use TestCheckout\Entities\Definitions\RuleAmountTypeInterface;
use TestCheckout\Entities\Definitions\RuleOperationTypeInterface;

interface RuleInterface
{
    public function setAmount(float $amount): static;

    public function getAmount(): float;

    public function setAmountType(RuleAmountTypeInterface $amountType): static;

    public function getAmountType(): RuleAmountTypeInterface;

    public function setOperationType(RuleOperationTypeInterface $feeOperationType): static;

    public function getOperationType(): RuleOperationTypeInterface;

    public function getOptionsNames(): array;

    public function setOptions(mixed ...$options): static;
}
