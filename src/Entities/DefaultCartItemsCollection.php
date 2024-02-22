<?php

declare(strict_types=1);

namespace TestCheckout\Entities;

use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Entities\Definitions\CartItemsCollectionInterface;

class DefaultCartItemsCollection implements CartItemsCollectionInterface
{
    /**
     * @var CartItemInterface[]
     */
    private array $cartItems = [];

    public function current(): CartItemInterface
    {
        return current($this->cartItems);
    }

    public function count(): int
    {
        return count($this->cartItems);
    }

    public function append(CartItemInterface $item): void
    {
        $this->cartItems[] = $item;
    }

    public function offsetExists(int|string $offset): bool
    {
        return isset($this->cartItems[$offset]);
    }

    public function offsetGet(int|string $offset): CartItemInterface
    {
        return $this->cartItems[$offset];
    }

    public function offsetSet(int|string $offset, CartItemInterface $value): void
    {
        $this->cartItems[$offset] = $value;
    }

    public function offsetUnset(int|string $offset): void
    {
        unset($this->cartItems[$offset]);
    }

    public function next(): void
    {
        next($this->cartItems);
    }

    public function key(): int|float
    {
        return key($this->cartItems);
    }

    public function valid(): bool
    {
        return true;
    }

    public function rewind(): void
    {
        reset($this->cartItems);
    }
}
