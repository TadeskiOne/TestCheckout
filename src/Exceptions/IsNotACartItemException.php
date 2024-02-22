<?php

declare(strict_types=1);

namespace TestCheckout\Exceptions;

use TestCheckout\Entities\Definitions\CartItemInterface;

class IsNotACartItemException extends \Exception
{
    public $message = 'Cart item object should be instance of '.CartItemInterface::class;
}
