<?php

use TestCheckout\Entities\ReducingAmountType;
use TestCheckout\Entities\ReducingOperationType;

return [
    [
        'code'              => 'FR1',
        'name'              => 'Fruit of tea',
        'price'             => 3.11,
        'discountAmount'    => 50,
        'discountType'      => ReducingAmountType::percentage,
        'discountOperation' => ReducingOperationType::discount,
        'expected'          => 1.56,
    ],
    [
        'code'              => 'FR1',
        'name'              => 'Fruit of tea',
        'price'             => 3.11,
        'discountAmount'    => 100,
        'discountType'      => ReducingAmountType::percentage,
        'discountOperation' => ReducingOperationType::discount,
        'expected'          => 0,
    ],
    [
        'code'              => 'FR1',
        'name'              => 'Fruit of tea',
        'price'             => 3.11,
        'discountAmount'    => 3,
        'discountType'      => ReducingAmountType::amount,
        'discountOperation' => ReducingOperationType::discount,
        'expected'          => 0.11,
    ],
    [
        'code'              => 'FR1',
        'name'              => 'Fruit of tea',
        'price'             => 3.11,
        'discountAmount'    => 25,
        'discountType'      => ReducingAmountType::amount,
        'discountOperation' => ReducingOperationType::replacement,
        'expected'          => 25,
    ],
    [
        'code'              => 'FR1',
        'name'              => 'Fruit of tea',
        'price'             => 3.11,
        'discountAmount'    => 25,
        'discountType'      => ReducingAmountType::percentage,
        'discountOperation' => ReducingOperationType::replacement,
        'expected'          => 0.78,
    ],
];