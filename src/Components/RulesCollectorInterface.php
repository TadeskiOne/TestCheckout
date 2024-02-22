<?php

declare(strict_types=1);

namespace TestCheckout\Components;

use TestCheckout\Rules\Definitions\RuleInterface;

interface RulesCollectorInterface
{
    public function collectRule(string $identifier): RuleInterface;
}
