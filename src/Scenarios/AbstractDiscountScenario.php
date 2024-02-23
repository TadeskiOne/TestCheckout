<?php

declare(strict_types=1);

namespace TestCheckout\Scenarios;

use TestCheckout\Components\RulesCollectorInterface;
use TestCheckout\Components\RulesMath;
use TestCheckout\Entities\Definitions\CartItemsCollectionInterface;
use TestCheckout\Scenarios\Definitions\CheckoutPricingScenarioInterface;

abstract class AbstractDiscountScenario implements CheckoutPricingScenarioInterface
{
    protected ?CartItemsCollectionInterface $cartItems;
    protected array $availableProductCodes = [];

    public function __construct(
        protected readonly RulesCollectorInterface $collector,
        protected readonly RulesMath $operations
    ) {
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
