<?php

namespace App\Services\Projects;

use App\Models\Project;
use App\Models\Data;
use Illuminate\Support\Facades\DB;
use App\Services\Support\CurrencyService;
use App\Services\Support\ColorService;

class ProjectChartService
{
    private const INVESTMENT_TYPES = [
        'Innovation',
        'Efficiency & Saving',
        'Replacement & Restructuring',
        'Quality & Hygiene',
        'Health & Safety',
        'Environment',
        'Maintenance',
        'Capacity Increase'
    ];

    private const TYPE_COLORS = [
        'Innovation' => '#f6ad55',
        'Efficiency & Saving' => '#fc8181',
        'Replacement & Restructuring' => '#90cdf4',
        'Quality & Hygiene' => '#66DA26',
        'Health & Safety' => '#ffce56',
        'Environment' => '#4bc0c0',
        'Maintenance' => '#36a2eb',
        'Capacity Increase' => '#9966FF',
    ];

    private const STATE_COLORS = [
        'Capex' => '#5BCA5A',
        'Execution' => '#5BCA5A',
        'Finished' => '#CC5555',
        'Planification' => '#FFA500',
        'Total' => '#800080',
    ];

    public function __construct(
        private CurrencyService $currencyService,
        private ColorService $colorService,
        private ProjectFilterService $filterService
    ) {}

    public function getChartData(array $filters): array
    {
        return [
            'investment_by_type' => $this->getInvestmentByType($filters),
            'projects_by_state' => $this->getProjectsByState($filters),
            'budget_by_state' => $this->getBudgetByState($filters),
            'budget_by_area' => $this->getBudgetByArea($filters),
            'projects_by_investment' => $this->getProjectsByInvestmentType($filters)
        ];
    }

    public function getConfig(): array
    {
        return [
            'investment_types' => self::INVESTMENT_TYPES,
            'type_colors' => self::TYPE_COLORS,
            'state_colors' => self::STATE_COLORS
        ];
    }

    public function getInvestmentByType(array $filters)
    {
        $query = Project::select('investments')
            ->selectRaw('SUM(data.global_price_euros) as total')
            ->leftJoin('data', 'projects.id', '=', 'data.project_id')
            ->where('projects.data_uploaded', true)
            ->whereIn('investments', self::INVESTMENT_TYPES);

        $this->filterService->applyFilters($query, $filters);

        return $query->groupBy('investments')
            ->get()
            ->map(function ($item) use ($filters) {
                return [
                    'label' => $item->investments,
                    'value' => $this->currencyService->convert($item->total, $filters),
                    'color' => self::TYPE_COLORS[$item->investments] ?? $this->colorService->generateColor()
                ];
            })
            ->sortByDesc('value')
            ->values();
    }

    public function getProjectsByState(array $filters)
    {
        $projectsData = [];
        $totalProjects = $this->getTotalProjectsCount($filters);

        $projectsData['Total'] = $totalProjects;

        $state = $filters['stateSearch'] ?? 'all';
        if ($state === 'all') {
            $states = ['Execution', 'Planification', 'Finished'];
            foreach ($states as $state) {
                $projectsData[$state] = $this->getProjectsCountByState($filters, $state);
            }
        } else {
            $projectsData[$state] = $this->getProjectsCountByState($filters, $state);
        }

        return collect($projectsData)->map(function ($count, $state) {
            return [
                'label' => $state,
                'value' => $count,
                'color' => self::STATE_COLORS[$state] ?? $this->colorService->generateColor()
            ];
        })->sortByDesc('value')->values();
    }

    public function getBudgetByState(array $filters)
    {
        $query = Project::select('state')
            ->selectRaw('SUM(data.global_price_euros) as total')
            ->leftJoin('data', 'projects.id', '=', 'data.project_id')
            ->where('projects.data_uploaded', true);

        $this->filterService->applyFilters($query, $filters);

        return $query->groupBy('state')
            ->get()
            ->map(function ($item) use ($filters) {
                return [
                    'label' => $item->state,
                    'value' => $this->currencyService->convert($item->total, $filters),
                    'color' => self::STATE_COLORS[$item->state] ?? $this->colorService->generateColor()
                ];
            })
            ->sortByDesc('value')
            ->values();
    }

    public function getBudgetByArea(array $filters)
    {
        $query = Project::select('data.area')
            ->selectRaw('SUM(data.global_price_euros) as total')
            ->leftJoin('data', 'projects.id', '=', 'data.project_id')
            ->where('projects.data_uploaded', true);

        $this->filterService->applyFilters($query, $filters);

        return $query->groupBy('data.area')
            ->get()
            ->map(function ($item) use ($filters) {
                return [
                    'area' => $item->area ?? 'No Area',
                    'total' => $this->currencyService->convert($item->total, $filters)
                ];
            });
    }

    public function getProjectsByInvestmentType(array $filters)
    {
        $query = Project::where('data_uploaded', true)
            ->whereIn('investments', self::INVESTMENT_TYPES);

        $this->filterService->applyFilters($query, $filters);

        return $query->get()
            ->groupBy('investments')
            ->map(function ($projects, $type) {
                return [
                    'type' => $type,
                    'count' => $projects->count(),
                    'color' => self::TYPE_COLORS[$type] ?? $this->colorService->generateColor()
                ];
            })
            ->sortByDesc('count')
            ->values();
    }

    private function getTotalProjectsCount(array $filters): int
    {
        $metricService = app(ProjectMetricService::class);
        return $metricService->getTotalProjectsCount($filters);
    }

    private function getProjectsCountByState(array $filters, string $state): int
    {
        $metricService = app(ProjectMetricService::class);
        return $metricService->getProjectsCountByState($filters, $state);
    }
}
