<?php

namespace TestCheckout\Checkout;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use TestCheckout\Checkout;
use TestCheckout\Components\RulesCollectorInterface;
use TestCheckout\Components\RulesMath;
use TestCheckout\Entities\Definitions\CartFactoryInterface;
use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Rules\ChangePriceFromQtyRule;
use TestCheckout\Rules\SimpleChangePriceRule;
use TestCheckout\Scenarios\BOGOFScenario;
use TestCheckout\Scenarios\BulkPurchaseScenario;

class CheckoutTest extends TestCase implements CartFactoryInterface
{
    use ProphecyTrait;

    public function testScenario()
    {
        $data = require __DIR__ . '/test_checkout.php';

        $math = new RulesMath();

        $rulesCollector = $this->prophesize(RulesCollectorInterface::class);
        $rulesCollector->collectRule(ChangePriceFromQtyRule::class)
           ->willReturn(new ChangePriceFromQtyRule($math));
        $rulesCollector->collectRule(SimpleChangePriceRule::class)
           ->willReturn(new SimpleChangePriceRule($math));
        $rulesCollector = $rulesCollector->reveal();

        $checkout = new Checkout(
            new \ArrayObject(
                [
                    BOGOFScenario::class => (new BOGOFScenario($rulesCollector, $this, $math))
                        ->setAvailableProductCodes($data['available_products'][BOGOFScenario::class]),
                    BulkPurchaseScenario::class => (new BulkPurchaseScenario($rulesCollector, $math))
                        ->setAvailableProductCodes($data['available_products'][BulkPurchaseScenario::class])
                ]
            )
        );

        foreach ($data['items'] as $rawCartItem) {
            $cartItem = $this->prophesize(CartItemInterface::class);
            $cartItem->getCode()->willReturn($rawCartItem['code']);
            $cartItem->getName()->willReturn($rawCartItem['name']);
            $cartItem->getPrice()->willReturn($rawCartItem['price']);
            $cartItem->getQuantity()->willReturn($rawCartItem['quantity']);

            $checkout->scan($cartItem->reveal());
        }

        $this->assertEquals($data['expectedTotal'], $checkout->total());
        $this->assertEquals($data['expectedItemsCount'], $checkout->getCartItems()->count());
    }

    public function makeItem(string $code, string $name, float|int $quantity, float $price): CartItemInterface
    {
        $cartItem = $this->prophesize(CartItemInterface::class);
        $cartItem->getCode()->willReturn($code);
        $cartItem->getName()->willReturn($name);
        $cartItem->getQuantity()->willReturn($quantity);
        $cartItem->getPrice()->willReturn($price);

        return $cartItem->reveal();
    }
}