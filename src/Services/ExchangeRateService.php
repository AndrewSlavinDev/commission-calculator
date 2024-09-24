<?php

namespace App\Services;

use App\Contracts\ExchangeRateServiceInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class ExchangeRateService implements ExchangeRateServiceInterface
{
    private string $apiUrl = 'https://api.exchangeratesapi.io/latest';

    public function __construct(private readonly ClientInterface $client)
    {
    }

    /**
     * @throws \Exception
     */
    public function getRate(string $currency): float
    {
        try {
            $response = $this->client->get($this->apiUrl);
            $rates = json_decode($response->getBody(), true)['rates'];

            if (!isset($rates[$currency])) {
                throw new \Exception('Currency not found');
            }

            return $rates[$currency];
        } catch (GuzzleException $e) {
            throw new \Exception('Exchange rate service error: ' . $e->getMessage());
        }
    }
}
