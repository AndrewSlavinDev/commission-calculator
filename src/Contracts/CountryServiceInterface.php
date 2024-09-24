<?php

namespace App\Contracts;

interface CountryServiceInterface
{
    public function isEuCountry(string $countryCode): bool;
}