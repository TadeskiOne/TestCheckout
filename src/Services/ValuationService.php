<?php

declare(strict_types=1);

namespace TestCheckout\Services;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use TestCheckout\Entities\Definitions\CartItemInterface;
use TestCheckout\Entities\Definitions\DataProviderInterface;
use TestCheckout\Scenarios\Definitions\ScenarioInterface;
use TestCheckout\Valuation\CommissionsFee\Scenarios\DepositScenario;
use TestCheckout\Valuation\CommissionsFee\Scenarios\WithdrawScenario;

/**
 * Class ValuationService
 *s
 * This class is responsible for calculating commission fees for transactions using different scenarios.
 */
final class ValuationService
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function calculateCommissionFees(DataProviderInterface $dataProvider): \ArrayAccess
    {
        $fees = new \ArrayObject([]);

        $scenariosByPriority = [
            DepositScenario::class,
            WithdrawScenario::class,
        ];

        foreach ($dataProvider as $transaction) {
            foreach ($scenariosByPriority as $scenarioIdentifier) {
                try {
                    /**
                     * @var ScenarioInterface $scenario
                     * @var CartItemInterface $feeTransaction
                     */
                    $scenario = $this->container->get($scenarioIdentifier);
                    $feeTransaction = $scenario->applyTo($transaction);

                    if ($feeTransaction === null) {
                        continue;
                    }

                    $fees->append($feeTransaction->getAmount());
                } catch (NotFoundExceptionInterface $e) {
                    continue;
                }
            }

            unset($rules);
        }

        return $fees;
    }
}
