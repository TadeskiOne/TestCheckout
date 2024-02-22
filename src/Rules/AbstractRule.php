<?php

declare(strict_types=1);

namespace TestCheckout\Rules;

use TestCheckout\Components\RulesMath;
use TestCheckout\Entities\Definitions\RuleAmountTypeInterface;
use TestCheckout\Entities\Definitions\RuleOperationTypeInterface;
use TestCheckout\Entities\ReducingAmountType;
use TestCheckout\Entities\ReducingOperationType;
use TestCheckout\Rules\Definitions\RuleInterface;

abstract class AbstractRule implements RuleInterface
{
    protected float $amount = 0.00;

    protected RuleAmountTypeInterface $amountType;

    protected RuleOperationTypeInterface $feeOperationType;

    public function __construct(protected readonly RulesMath $operations)
    {
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmountType(RuleAmountTypeInterface $amountType): static
    {
        $this->amountType = $amountType;

        return $this;
    }

    public function getAmountType(): ReducingAmountType
    {
        return $this->amountType;
    }

    public function setOperationType(RuleOperationTypeInterface $feeOperationType): static
    {
        $this->feeOperationType = $feeOperationType;

        return $this;
    }

    public function getOperationType(): ReducingOperationType
    {
        return $this->feeOperationType;
    }

    public function getOptionsNames(): array
    {
        return [];
    }

    public function setOptions(...$options): static
    {
        return $this;
    }
}
