<?php

namespace App\Services\Dashboard;

use App\Services\Projects\ProjectFilterService;
use App\Services\Projects\ProjectMetricService;
use App\Services\Projects\ProjectChartService;

class DashboardService
{
    public function __construct(
        private ProjectFilterService $projectFilterService,
        private ProjectMetricService $projectMetricService,
        private ProjectChartService $projectChartService
    ) {}

    public function getDashboardData(array $filters = []): array
    {
        return [
            'filterOptions' => $this->projectFilterService->getFilterOptions(),
            'mainMetrics' => $this->projectMetricService->getMainMetrics($filters),
            'chartData' => $this->projectChartService->getChartData($filters),
            'config' => $this->projectChartService->getConfig()
        ];
    }
}
