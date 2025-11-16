<?php

namespace App\Services\Support;

class CapexCalculator
{
    private const CAPEX_VALUES = [
        '2022' => 500000,
        '2023' => 2614420,
        '2024' => 1660000,
        '2025' => 5104000
    ];

    public function calculatePercentage(float $budgeted, ?string $year): float
    {
        if ($year === "2025") {
            return 0.0;
        }

        $capexValue = $year && $year !== 'all'
            ? (self::CAPEX_VALUES[$year] ?? 0)
            : array_sum(self::CAPEX_VALUES);

        return $capexValue > 0 ? round(($budgeted / $capexValue) * 100, 2) : 0;
    }

    public function getCapexValues(): array
    {
        return self::CAPEX_VALUES;
    }
}
