<?php

declare(strict_types=1);

namespace TestCheckout\Entities\Definitions;

interface CartItemInterface
{
    public function getCode(): string;

    public function getName(): string;

    public function getQuantity(): int|float;

    public function getPrice(): float;
}
