<?php

namespace App\Services\Dashboard;

use App\Services\Projects\ProjectChartService;
use App\Services\Projects\ProjectFilterService;
use App\Services\Projects\ProjectMetricService;

class DashboardDataService
{
    public function __construct(
        private ProjectFilterService $projectFilterService,
        private ProjectMetricService $projectMetricService,
        private ProjectChartService $projectChartService
    ) {}

    public function getAllData(array $filters = []): array
    {
        return [
            'filters' => $this->projectFilterService->getFilterOptions(),
            'metrics' => $this->projectMetricService->getMainMetrics($filters),
            'charts' => $this->projectChartService->getChartData($filters),
            'configuration' => $this->projectChartService->getConfig()
        ];
    }

    public function getMetricsOnly(array $filters = []): array
    {
        return $this->projectMetricService->getMainMetrics($filters);
    }

    public function getChartsOnly(array $filters = []): array
    {
        return $this->projectChartService->getChartData($filters);
    }
}
