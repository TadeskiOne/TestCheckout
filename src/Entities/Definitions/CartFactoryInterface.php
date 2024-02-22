<?php

declare(strict_types=1);

namespace TestCheckout\Entities\Definitions;

interface CartFactoryInterface
{
    public function makeItem(
        string $code,
        string $name,
        int|float $quantity,
        float $price
    ): CartItemInterface;
}
