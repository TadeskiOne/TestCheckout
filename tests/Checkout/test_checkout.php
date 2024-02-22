<?php

return [
    'available_products' => [
        \TestCheckout\Scenarios\BOGOFScenario::class        => ['FR1'],
        \TestCheckout\Scenarios\BulkPurchaseScenario::class => ['SR1'],
    ],
    'items'              => [
        [
            'code'     => 'FR1',
            'name'     => 'Fruit of tea 1',
            'price'    => 3.11,
            'quantity' => 2,
        ],
        [
            'code'     => 'SR1',
            'name'     => 'Strawberries 1',
            'price'    => 5.00,
            'quantity' => 3,
        ],
        [
            'code'     => 'CF1',
            'name'     => 'Coffee 1',
            'price'    => 11.23,
            'quantity' => 3,
        ],
    ],
    'expectedTotal'      => 53.41,
    'expectedItemsCount' => 4,
];