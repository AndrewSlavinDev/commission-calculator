<?php

namespace App\Contracts;

interface BinServiceInterface
{
    public function getBinCountry(string $bin): string;
}