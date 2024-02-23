<?php

return [
    'available_products' => [
        \TestCheckout\Scenarios\BOGOFScenario::class        => ['FR1'],
        \TestCheckout\Scenarios\BulkPurchaseScenario::class => ['SR1'],
    ],
    'cases'              => [
        [
            'items'              => [
                [
                    'code'     => 'FR1',
                    'name'     => 'Fruit of tea',
                    'price'    => 3.11,
                ],
                [
                    'code'     => 'SR1',
                    'name'     => 'Strawberries',
                    'price'    => 5.00,
                ],
                [
                    'code'     => 'FR1',
                    'name'     => 'Fruit of tea',
                    'price'    => 3.11,
                ],
                [
                    'code'     => 'FR1',
                    'name'     => 'Fruit of tea',
                    'price'    => 3.11,
                ],
                [
                    'code'     => 'CF1',
                    'name'     => 'Coffee',
                    'price'    => 11.23,
                ],
            ],
            'expectedTotal'      => 22.45,
        ],
        [
            'items'              => [
                [
                    'code'     => 'FR1',
                    'name'     => 'Fruit of tea',
                    'price'    => 3.11,
                ],
                [
                    'code'     => 'FR1',
                    'name'     => 'Fruit of tea',
                    'price'    => 3.11,
                ],
            ],
            'expectedTotal'      => 3.11,
        ],
        [
            'items'              => [
                [
                    'code'     => 'SR1',
                    'name'     => 'Strawberries',
                    'price'    => 5.00,
                ],
                [
                    'code'     => 'FR1',
                    'name'     => 'Fruit of tea',
                    'price'    => 3.11,
                ],
                [
                    'code'     => 'SR1',
                    'name'     => 'Strawberries',
                    'price'    => 5.00,
                ],
                [
                    'code'     => 'SR1',
                    'name'     => 'Strawberries',
                    'price'    => 5.00,
                ],
            ],
            'expectedTotal'      => 16.61,
        ],
    ],
];