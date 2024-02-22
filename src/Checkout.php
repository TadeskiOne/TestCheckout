<?php

declare(strict_types=1);

namespace TestCheckout;

use TestCheckout\Components\RulesMath;
use TestCheckout\Entities\DefaultCartItemsCollection;
use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Entities\Definitions\CartItemsCollectionInterface;
use TestCheckout\Scenarios\DefaultPricingScenario;
use TestCheckout\Scenarios\Definitions\CheckoutPricingScenarioInterface;
use TestCheckout\Scenarios\Definitions\DefaultScenarioInterfaceCheckout;

class Checkout
{
    private float $total = 0;
    private CartItemsCollectionInterface $cartItemsCollection;
    private DefaultScenarioInterfaceCheckout $defaultPricingScenario;

    public function __construct(private readonly \ArrayObject $pricingScenarios = new \ArrayObject())
    {
        $this->cartItemsCollection = new DefaultCartItemsCollection();
        $this->defaultPricingScenario = new DefaultPricingScenario(new RulesMath());

        /** @var CheckoutPricingScenarioInterface $scenario */
        foreach ($this->pricingScenarios as $scenario) {
            $scenario->setCartItems($this->cartItemsCollection);
        }
    }

    public function scan(CartItemInterface $cartItem): static
    {
        $this->cartItemsCollection->append($cartItem);

        if ($this->pricingScenarios->count() === 0) {
            $this->total += $cartItem->getPrice() * $cartItem->getQuantity();

            return $this;
        }

        $alreadyAppliedScenarios = new \ArrayObject();

        foreach ($this->pricingScenarios as $scenario) {
            $this->total += $scenario->applyTo($cartItem, $alreadyAppliedScenarios);
        }

        $this->total += $this->defaultPricingScenario->applyTo($cartItem, $alreadyAppliedScenarios);

        return $this;
    }

    public function getCartItems(): CartItemsCollectionInterface
    {
        return $this->cartItemsCollection;
    }

    public function total(): float
    {
        return $this->total;
    }
}
