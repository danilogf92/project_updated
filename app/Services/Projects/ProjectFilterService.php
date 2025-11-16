<?php

namespace App\Services\Projects;

use App\Models\Project;
use Carbon\Carbon;

class ProjectFilterService
{
    public function getFilterOptions(): array
    {
        return [
            'years' => $this->getYears(),
            'states' => $this->getDistinctValues('state'),
            'projectTypes' => $this->getDistinctValues('classification_of_investments'),
            'justifications' => $this->getDistinctValues('justification'),
            'plants' => $this->getPlants()
        ];
    }

    public function getYears()
    {
        return Project::where('data_uploaded', true)
            ->distinct()
            ->get(['start_date'])
            ->pluck('start_date')
            ->map(fn($date) => Carbon::parse($date)->format('Y'))
            ->unique()
            ->sortDesc()
            ->values();
    }

    public function getDistinctValues(string $column)
    {
        return Project::distinct()
            ->where('data_uploaded', true)
            ->pluck($column)
            ->filter()
            ->values();
    }

    public function getPlants(): array
    {
        return [
            'CIESA' => 'Ciesa',
            'GRALCO' => 'Gralco',
            'SEAF' => 'Seafman'
        ];
    }

    public function applyFilters($query, array $filters): void
    {
        $query->when(isset($filters['yearSearch']) && is_numeric($filters['yearSearch']), function ($q) use ($filters) {
            $q->whereYear('start_date', $filters['yearSearch']);
        })
            ->when(isset($filters['stateSearch']) && $filters['stateSearch'] !== 'all', function ($q) use ($filters) {
                $q->where('state', $filters['stateSearch']);
            })
            ->when(isset($filters['typeOfProjectSearch']) && $filters['typeOfProjectSearch'] !== 'all', function ($q) use ($filters) {
                $q->where('classification_of_investments', $filters['typeOfProjectSearch']);
            })
            ->when(isset($filters['justification']) && $filters['justification'] !== 'all', function ($q) use ($filters) {
                $q->where('justification', $filters['justification']);
            })
            ->when(isset($filters['plantFilter']) && $filters['plantFilter'] !== 'all', function ($q) use ($filters) {
                $q->where('pda_code', 'LIKE', '%' . $filters['plantFilter'] . '%');
            });
    }
}
