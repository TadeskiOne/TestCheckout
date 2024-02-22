<?php

declare(strict_types=1);

namespace TestCheckout\Entities;

use TestCheckout\Entities\Definitions\RuleAmountTypeInterface;

enum ReducingAmountType: int implements RuleAmountTypeInterface
{
    case percentage = 0;
    case amount = 1;
}
