<?php

namespace App\Services;

use App\Contracts\ExchangeRateServiceInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

readonly class ExchangeRateService implements ExchangeRateServiceInterface
{
    public function __construct(private ClientInterface $client)
    {
    }

    /**
     * @throws \Exception
     */
    public function getRate(string $currency): float
    {
        try {
            $response = $this->client->get(EXCHANGE_RATE_API_URL);
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
