<?php

namespace Tests;

use App\Contracts\BinServiceInterface;
use App\Contracts\ExchangeRateServiceInterface;
use App\Contracts\CountryServiceInterface;
use App\Services\CommissionCalculator;
use Mockery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CommissionCalculator::class)]
class CommissionCalculatorTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @throws \Exception
     */
    public function testCalculateCommissionForEuTransaction()
    {
        $binService = Mockery::mock(BinServiceInterface::class);
        $exchangeRateService = Mockery::mock(ExchangeRateServiceInterface::class);
        $euCountryService = Mockery::mock(CountryServiceInterface::class);

        $binService->allows('getBinCountry')->andReturns('FR');
        $exchangeRateService->allows('getRate')->andReturns(1.0);
        $euCountryService->allows('isEuCountry')->with('FR')->andReturns(true);

        $calculator = new CommissionCalculator(
            $binService,
            $exchangeRateService,
            $euCountryService
        );

        $transaction = [
            'bin' => '45717360',
            'amount' => 100,
            'currency' => 'EUR'
        ];

        $this->assertEquals(1.0, $calculator->calculate($transaction));
    }

    /**
     * @throws \Exception
     */
    public function testCalculateCommissionForNonEuTransaction()
    {
        $binService = Mockery::mock(BinServiceInterface::class);
        $exchangeRateService = Mockery::mock(ExchangeRateServiceInterface::class);
        $euCountryService = Mockery::mock(CountryServiceInterface::class);

        $binService->allows('getBinCountry')->andReturns('US');
        $exchangeRateService->allows('getRate')->andReturns(1.2);
        $euCountryService->allows('isEuCountry')->with('US')->andReturns(false);

        $calculator = new CommissionCalculator(
            $binService,
            $exchangeRateService,
            $euCountryService
        );


        $transaction = [
            'bin' => '516793',
            'amount' => 50,
            'currency' => 'USD'
        ];

        $this->assertEquals(0.84, $calculator->calculate($transaction));
    }
}
