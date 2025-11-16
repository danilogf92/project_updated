<?php

namespace App\Services\Projects;

use App\Models\Data;
use App\Models\Project;
use App\Services\Support\CurrencyService;
use App\Services\Support\CapexCalculator;

class ProjectMetricService
{
    public function __construct(
        private CurrencyService $currencyService,
        private CapexCalculator $capexCalculator,
        private ProjectFilterService $filterService
    ) {}

    public function getMainMetrics(array $filters): array
    {
        $budgeted = $this->getSumByFilters($filters, 'global_price_euros');
        $capexPercentage = $this->capexCalculator->calculatePercentage(
            $budgeted,
            $filters['yearSearch'] ?? 'all'
        );

        return [
            'total_projects' => $this->getTotalProjectsCount($filters),
            'budgeted' => $budgeted,
            'booked' => $this->getSumByFilters($filters, 'booked_euros'),
            'executed' => $this->getSumByFilters($filters, 'executed_euros'),
            'capex_percentage' => $capexPercentage,
            'currency' => $filters['dollarOrEuro'] ?? 'euro'
        ];
    }

    public function getSumByFilters(array $filters, string $column): float
    {
        $value = Data::whereHas('project', function ($query) use ($filters) {
            $query->where('data_uploaded', true);
            $this->filterService->applyFilters($query, $filters);
        })->sum($column);

        return $this->currencyService->convert($value, $filters);
    }

    public function getTotalProjectsCount(array $filters): int
    {
        $query = Project::where('data_uploaded', true);
        $this->filterService->applyFilters($query, $filters);
        return $query->count();
    }

    public function getProjectsCountByState(array $filters, string $state): int
    {
        $query = Project::where('state', $state)
            ->where('data_uploaded', true);

        $this->filterService->applyFilters($query, $filters);
        return $query->count();
    }
}
