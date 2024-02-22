<?php

namespace TestCheckout\ScenariosCases;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use TestCheckout\Components\RulesCollectorInterface;
use TestCheckout\Components\RulesMath;
use TestCheckout\Entities\DefaultCartItemsCollection;
use TestCheckout\Entities\Definitions\CartFactoryInterface;
use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Rules\SimpleChangePriceRule;
use TestCheckout\Scenarios\BOGOFScenario;

class BOGOFScenarioTest extends TestCase implements CartFactoryInterface
{
    use ProphecyTrait;

    public function testScenario()
    {
        $data = require __DIR__ . '/test_buy_one_get_one_free.php';

        $math = new RulesMath();

        $cartItems = new DefaultCartItemsCollection();

        $rulesCollector = $this->prophesize(RulesCollectorInterface::class);
        $rulesCollector->collectRule(SimpleChangePriceRule::class)
             ->willReturn(new SimpleChangePriceRule($math));

        $scenario = (new BOGOFScenario($rulesCollector->reveal(), $this, $math))
            ->setCartItems($cartItems)
            ->setAvailableProductCodes($data['available_products']);

        $appliedScenarios = new \ArrayObject();

        foreach ($data['items'] as $rawCartItem) {
            $cartItem = $this->prophesize(CartItemInterface::class);
            $cartItem->getCode()->willReturn($rawCartItem['code']);
            $cartItem->getName()->willReturn($rawCartItem['name']);
            $cartItem->getPrice()->willReturn($rawCartItem['price']);
            $cartItem->getQuantity()->willReturn($rawCartItem['quantity']);
            $cartItem = $cartItem->reveal();
            $cartItems->append($cartItem);

            $result = $scenario->applyTo($cartItem, $appliedScenarios);
            $this->assertEquals($rawCartItem['expected'], $result);
        }

        $this->assertEquals($data['expected_items_in_cart_count'], $cartItems->count());
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