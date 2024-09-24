<?php

namespace App\Services;

use App\Contracts\BinServiceInterface;
use App\Contracts\CountryServiceInterface;
use App\Contracts\ExchangeRateServiceInterface;

readonly class CommissionCalculator
{

    public function __construct(
        private BinServiceInterface $binService,
        private ExchangeRateServiceInterface $exchangeRateService,
        private CountryServiceInterface $countryService
    ) {
    }

    /**
     * @throws \Exception
     */
    public function calculate(array $transaction): float|false
    {
        try {
            $binCountry = $this->binService->getBinCountry($transaction['bin']);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $isEu = $this->countryService->isEuCountry($binCountry);

        $rate = ($transaction['currency'] === 'EUR')
            ? 1
            : $this->exchangeRateService->getRate($transaction['currency']);

        $amountInEur = $transaction['amount'] / $rate;

        $commissionRate = $isEu ? 0.01 : 0.02;
        $commission = $amountInEur * $commissionRate;

        return ceil($commission * 100) / 100; // Round up to nearest cent
    }
}
