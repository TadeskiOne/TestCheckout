<?php

declare(strict_types=1);

namespace TestCheckout\Entities;

use TestCheckout\Entities\Definitions\RuleOperationTypeInterface;

enum ReducingOperationType: int implements RuleOperationTypeInterface
{
    case discount = 0;
    case replacement = 1;
}
