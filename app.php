<?php

include_once 'vendor/autoload.php';

use App\TransactionProcessor;

try {
    (new TransactionProcessor())->processFile($argv[1]);
} catch (Exception $e) {
    var_dump($e->getTraceAsString());
}
