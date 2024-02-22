<?php

use TestCheckout\Entities\ReducingAmountType;
use TestCheckout\Entities\ReducingOperationType;

return [
    'available_products' => [
        'FR1',
        'FR2',
    ],
    'items'              => [
        [
            'code'              => 'FR1',
            'name'              => 'Fruit of tea 1',
            'price'             => 3.11,
            'quantity'          => 2,
            'expected'          => 6.22,
        ],
        [
            'code'              => 'FR2',
            'name'              => 'Fruit of tea 2',
            'price'             => 3.75,
            'quantity'          => 5,
            'expected'          => 18.75,
        ],
        [
            'code'              => 'SR1',
            'name'              => 'Strawberries 1',
            'price'             => 5.00,
            'quantity'          => 3,
            'expected'          => 0,
        ],
        [
            'code'              => 'SR2',
            'name'              => 'Strawberries 2',
            'price'             => 4.75,
            'quantity'          => 2,
            'expected'          => 0,
        ],
        [
            'code'              => 'CF1',
            'name'              => 'Coffee 1',
            'price'             => 11.23,
            'quantity'          => 3,
            'expected'          => 0,
        ],
        [
            'code'              => 'CF2',
            'name'              => 'Coffee 2',
            'price'             => 14.05,
            'quantity'          => 6,
            'expected'          => 0,
        ],
    ],
    'expected_items_in_cart_count' => 8,
];