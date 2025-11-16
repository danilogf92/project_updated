<?php

namespace App\Livewire;

use App\Services\Projects\ProjectMetricService;
use Livewire\Component;

class DashboardMetrics extends Component
{
    public $metrics = [];

    protected $listeners = ['filters-updated' => 'updateMetrics'];

    public function mount(ProjectMetricService $metricService)
    {
        $this->metrics = $metricService->getMainMetrics([]);
    }

    public function updateMetrics($filters)
    {
        // Convertir los filtros a la estructura esperada por el servicio
        $filtersArray = [
            'yearSearch' => $filters['year'] !== 'all' ? $filters['year'] : null,
            'stateSearch' => $filters['state'] !== 'all' ? $filters['state'] : 'all',
            'typeOfProjectSearch' => $filters['projectType'] !== 'all' ? $filters['projectType'] : 'all',
            'justification' => $filters['justification'] !== 'all' ? $filters['justification'] : 'all',
            'plantFilter' => $filters['plant'] !== 'all' ? $filters['plant'] : 'all',
            'dollarOrEuro' => $filters['currency'],
            'rateValue' => $filters['rateValue']
        ];

        // Llamar al servicio para obtener las métricas actualizadas
        $metricService = app(ProjectMetricService::class);
        $this->metrics = $metricService->getMainMetrics($filtersArray);

        // Re-renderizar la vista
        $this->render();
    }

    public function render()
    {
        return view('livewire.dashboard-metrics', ['metrics' => $this->metrics]);
    }
}
