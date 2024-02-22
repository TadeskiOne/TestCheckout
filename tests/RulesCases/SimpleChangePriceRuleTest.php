<?php

declare(strict_types=1);

namespace TestCheckout\RulesCases;

use Prophecy\PhpUnit\ProphecyTrait;
use TestCheckout\Components\RulesMath;
use TestCheckout\Entities\Definitions\CartItemInterface;
use PHPUnit\Framework\TestCase;
use TestCheckout\Rules\SimpleChangePriceRule;

class SimpleChangePriceRuleTest extends TestCase
{
    use ProphecyTrait;

    public function ruleCases(): iterable
    {
        $math = new RulesMath();

        foreach (require __DIR__ . '/test_simple_price_changing.php' as $ruleData) {
            $cartItem = $this->prophesize(CartItemInterface::class);
            $cartItem->getCode()->willReturn($ruleData['code']);
            $cartItem->getName()->willReturn($ruleData['name']);
            $cartItem->getPrice()->willReturn($ruleData['price']);
            $cartItem->getQuantity()->willReturn(1);
            $cartItem = $cartItem->reveal();

            yield [
                (new SimpleChangePriceRule($math))
                ->setAmount($ruleData['discountAmount'])
                ->setAmountType($ruleData['discountType'])
                ->setOperationType($ruleData['discountOperation'])
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
