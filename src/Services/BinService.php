<?php

namespace App\Services;

use App\Contracts\BinServiceInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

readonly class BinService implements BinServiceInterface
{
    public function __construct(private ClientInterface $client)
    {
    }

    /**
     * @throws \Exception
     */
    public function getBinCountry(string $bin): string
    {
        static $countries = [];

        if (isset($countries[$bin])) {
            return $countries[$bin];
        }

        try {
            $response = $this->client->get('https://lookup.binlist.net/' . $bin);
            $binData = json_decode($response->getBody());

            if (!isset($binData->country->alpha2)) {
                throw new \Exception('Invalid BIN data');
            }

            $countries[$bin] = $binData->country->alpha2;

            return $binData->country->alpha2;
        } catch (GuzzleException $e) {
            throw new \Exception('BIN service error: ' . $e->getMessage());
        }
    }
}
