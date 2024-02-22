<?php

namespace TestCheckout\ScenariosCases;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use TestCheckout\Components\RulesCollectorInterface;
use TestCheckout\Components\RulesMath;
use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Rules\ChangePriceFromQtyRule;
use TestCheckout\Rules\SimpleChangePriceRule;
use TestCheckout\Scenarios\BulkPurchaseScenario;

class BulkPurchaseScenarioTest extends TestCase
{
    use ProphecyTrait;

    public function testScenario()
    {
        $data = require __DIR__ . '/test_bulk_purchase.php';

        $math = new RulesMath();

        $rulesCollector = $this->prophesize(RulesCollectorInterface::class);
        $rulesCollector->collectRule(ChangePriceFromQtyRule::class)
                       ->willReturn(new ChangePriceFromQtyRule($math));
        $rulesCollector->collectRule(SimpleChangePriceRule::class)
                       ->willReturn(new SimpleChangePriceRule($math));

        $scenario = (new BulkPurchaseScenario($rulesCollector->reveal(), $math))
            ->setAvailableProductCodes($data['available_products']);

        $appliedScenarios = new \ArrayObject();

        foreach ($data['items'] as $rawCartItem) {
            $cartItem = $this->prophesize(CartItemInterface::class);
            $cartItem->getCode()->willReturn($rawCartItem['code']);
            $cartItem->getName()->willReturn($rawCartItem['name']);
            $cartItem->getPrice()->willReturn($rawCartItem['price']);
            $cartItem->getQuantity()->willReturn($rawCartItem['quantity']);

            $result = $scenario->applyTo($cartItem->reveal(), $appliedScenarios);
            $this->assertEquals($rawCartItem['expected'], $result);
        }
    }
}