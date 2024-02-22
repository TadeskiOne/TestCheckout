<?php

declare(strict_types=1);

namespace TestCheckout\Components;

use Psr\Container\ContainerInterface;
use TestCheckout\Rules\Definitions\RuleInterface;

class DefaultRulesCollector implements RulesCollectorInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function collectRule(string $identifier): RuleInterface
    {
        return $this->container->get($identifier);
    }
}
