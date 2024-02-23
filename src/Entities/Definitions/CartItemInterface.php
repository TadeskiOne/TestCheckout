<?php

declare(strict_types=1);

namespace TestCheckout\Entities\Definitions;

interface CartItemInterface
{
    public function getCode(): string;

    public function getName(): string;

    public function getPrice(): float;

    public function setPrice(float $price): void;
}
