<?php

declare(strict_types=1);

namespace TestCheckout\Exceptions;

use TestCheckout\Entities\Definitions\CartItemsCollectionInterface;

class IsNotACartItemsCollectionException extends \Exception
{
    public $message = 'Cart items collection should be instance of '.CartItemsCollectionInterface::class;
}
