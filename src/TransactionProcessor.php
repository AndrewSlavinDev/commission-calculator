<?php

namespace App;

use App\Services\BinService;
use App\Services\CommissionCalculator;
use App\Services\EuCountryService;
use App\Services\ExchangeRateService;
use GuzzleHttp\Client;

class TransactionProcessor
{

    /**
     * @throws \Exception
     */
    public function processFile(string $filename): void
    {
        if (!file_exists($filename)) {
            throw new \Exception('File not found');
        }

        $client = new Client();
        $commissionCalculator = new CommissionCalculator(
            new BinService($client),
            new ExchangeRateService($client),
            new EuCountryService()
        );

        $transactions = explode("\n", file_get_contents($filename));

        foreach ($transactions as $row) {
            if (empty($row)) {
                continue;
            }

            $transaction = json_decode($row, true);

            try {
                $commission = $commissionCalculator->calculate($transaction);
                echo $commission . "\n";
            } catch (\Exception $e) {
                echo 'Error processing transaction: ' . $e->getMessage() . "\n";
            }
        }
    }
}
