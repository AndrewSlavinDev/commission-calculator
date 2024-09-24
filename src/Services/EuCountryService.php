<?php

namespace App\Services;

use App\Contracts\CountryServiceInterface;

class EuCountryService implements CountryServiceInterface
{
    private array $euCountries = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR',
        'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO',
        'SE', 'SI', 'SK'
    ];

    public function isEuCountry(string $countryCode): bool
    {
        return in_array($countryCode, $this->euCountries);
    }
}
