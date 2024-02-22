<?php

declare(strict_types=1);

namespace TestCheckout\RulesCases;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use TestCheckout\Components\RulesMath;
use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Rules\ChangePriceFromQtyRule;

class ChangePriceFromQtyRuleTest extends TestCase
{
    use ProphecyTrait;

    public function ruleCases(): iterable
    {
        $math = new RulesMath();

        foreach (require __DIR__ . '/test_change_price_from_qty.php' as $ruleData) {
            $cartItem = $this->prophesize(CartItemInterface::class);
            $cartItem->getCode()->willReturn($ruleData['code']);
            $cartItem->getName()->willReturn($ruleData['name']);
            $cartItem->getPrice()->willReturn($ruleData['price']);
            $cartItem->getQuantity()->willReturn($ruleData['quantity']);
            $cartItem = $cartItem->reveal();

            yield [
                (new ChangePriceFromQtyRule($math))
                ->setAmount($ruleData['discountAmount'])
                ->setAmountType($ruleData['discountType'])
                ->setOperationType($ruleData['discountOperation'])
                ->setOptions(replaceFromQty: $ruleData['discountQty'])
                ->applyTo($cartItem),
                $ruleData['expected']
            ];
        }
    }

    /**
     * @dataProvider ruleCases
     */
    public function testRule($result, $expectedResult): void
    {
        $this->assertEquals($expectedResult, $result);
    }
}
