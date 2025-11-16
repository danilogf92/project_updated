<?php

namespace App\Services\Support;

class CurrencyService
{
    public function convert(float $amount, array $filters): float
    {
        $exchangeRate = $this->calculateExchangeRate($filters);
        return round($amount * $exchangeRate, 2);
    }

    private function calculateExchangeRate(array $filters): float
    {
        if (($filters['dollarOrEuro'] ?? 'euro') === "dollar") {
            $rate = (float)($filters['rateValue'] ?? 1);
            return $rate > 0 ? 1 / $rate : 1;
        }
        return 1;
    }

    public function getCurrencySymbol(array $filters): string
    {
        return ($filters['dollarOrEuro'] ?? 'euro') === 'dollar' ? '$' : '€';
    }
}
