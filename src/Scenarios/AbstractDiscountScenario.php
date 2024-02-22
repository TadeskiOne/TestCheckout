<?php

declare(strict_types=1);

namespace TestCheckout\Scenarios;

use TestCheckout\Components\RulesCollectorInterface;
use TestCheckout\Entities\Definitions\CartItemsCollectionInterface;
use TestCheckout\Scenarios\Definitions\CheckoutDiscountScenarioInterfaceCheckout;

abstract class AbstractDiscountScenario implements CheckoutDiscountScenarioInterfaceCheckout
{
    protected ?CartItemsCollectionInterface $cartItems;
    protected array $availableProductCodes = [];

    public function __construct(protected readonly RulesCollectorInterface $collector)
    {
    }

    public function setCartItems(?CartItemsCollectionInterface $dataProvider): static
    {
        $this->cartItems = $dataProvider;

        return $this;
    }

    public function setAvailableProductCodes(array $codes): static
    {
        $this->availableProductCodes = $codes;

        return $this;
    }
}
