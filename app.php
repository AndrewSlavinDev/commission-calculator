<?php

include_once 'vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();
include_once 'src/config/services.php';

use App\TransactionProcessor;

try {
    (new TransactionProcessor())->processFile($argv[1]);
} catch (Exception $e) {
    var_dump($e->getTraceAsString());
}
