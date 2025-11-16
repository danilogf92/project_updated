<?php

namespace App\Livewire;

use Livewire\Component;

class DashboardFilters extends Component
{
    public array $filterOptions = [];

    // Filtros seleccionados
    public $year = 'all';
    public $state = 'all';
    public $projectType = 'all';
    public $justification = 'all';
    public $plant = 'all';

    // Currency & rate
    public $currency = 'euro';
    public $rateValue = 1;

    public function mount(array $filterOptions)
    {
        $this->filterOptions = $filterOptions;
    }

    public function updated($property, $value)
    {
        // Si la moneda cambia a euro, resetear el rateValue a 1
        if ($property === 'currency' && $value === 'euro') {
            $this->rateValue = 1;
        }

        // Emitir evento global
        $this->dispatch('filters-updated', [
            'year'          => $this->year,
            'state'         => $this->state,
            'projectType'   => $this->projectType,
            'justification' => $this->justification,
            'plant'         => $this->plant,
            'currency'      => $this->currency,
            'rateValue'     => $this->rateValue
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard-filters');
    }
}
