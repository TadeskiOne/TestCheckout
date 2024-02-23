<?php

namespace TestCheckout\Checkout;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use TestCheckout\Checkout;
use TestCheckout\Components\RulesCollectorInterface;
use TestCheckout\Components\RulesMath;
use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Rules\SimpleChangePriceRule;
use TestCheckout\Scenarios\BOGOFScenario;
use TestCheckout\Scenarios\BulkPurchaseScenario;

class CheckoutTest extends TestCase
{
    use ProphecyTrait;

    public function testScenario()
    {
        $data = require __DIR__ . '/test_checkout.php';

        $math = new RulesMath();

        $rulesCollector = $this->prophesize(RulesCollectorInterface::class);
        $rulesCollector->collectRule(SimpleChangePriceRule::class)
           ->willReturn(new SimpleChangePriceRule($math));
        $rulesCollector = $rulesCollector->reveal();
        foreach ($data['cases'] as $case) {
            $checkout = new Checkout(
                new \ArrayObject(
                    [
                        BOGOFScenario::class        => (new BOGOFScenario($rulesCollector, $math))
                            ->setAvailableProductCodes($data['available_products'][BOGOFScenario::class]),
                        BulkPurchaseScenario::class => (new BulkPurchaseScenario($rulesCollector, $math))
                            ->setAvailableProductCodes($data['available_products'][BulkPurchaseScenario::class]),
                    ]
                )
            );

            foreach ($case['items'] as $rawCartItem) {
                $checkout->scan($this->getMockCartItem($rawCartItem));
            }

            $this->assertEquals($case['expectedTotal'], $checkout->total());
        }
    }

    private function getMockCartItem(array $rawCartItem): CartItemInterface
    {
        return new class(
            $rawCartItem['code'],
            $rawCartItem['name'],
            $rawCartItem['price'],
        ) implements CartItemInterface
        {
            public function __construct(
                private readonly string $code,
                private readonly string $name,
                private float           $price,
            ) {}


            public function getCode(): string
            {
                return $this->code;
            }

            public function getName(): string
            {
                return $this->name;
            }

            public function getPrice(): float
            {
                return $this->price;
            }

            public function setPrice(float $price): void
            {
                $this->price = $price;
            }
        };
    }
}