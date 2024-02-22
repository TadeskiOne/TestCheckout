<?php

declare(strict_types=1);

namespace TestCheckout\Entities\Definitions;

interface CartItemsCollectionInterface extends \Iterator
{
    public function current(): CartItemInterface;

    public function count(): int;

    public function append(CartItemInterface $item): void;

    public function offsetExists(int|string $offset): bool;

    public function offsetGet(int|string $offset): CartItemInterface;

    public function offsetSet(int|string $offset, CartItemInterface $value): void;

    public function offsetUnset(int|string $offset): void;
}
