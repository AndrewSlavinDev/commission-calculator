<?php

namespace App\Contracts;

interface ExchangeRateServiceInterface
{
    public function getRate(string $currency): float;
}