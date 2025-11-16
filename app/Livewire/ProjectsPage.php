<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectsPage extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 12;
    public $stateFilter = '';
    public $companyFilter = '';
    public $investmentFilter = '';
    public $yearFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 12],
        'stateFilter' => ['except' => ''],
        'companyFilter' => ['except' => ''],
        'investmentFilter' => ['except' => ''],
        'yearFilter' => ['except' => ''],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStateFilter()
    {
        $this->resetPage();
    }

    public function updatedCompanyFilter()
    {
        $this->resetPage();
    }

    public function updatedInvestmentFilter()
    {
        $this->resetPage();
    }

    public function updatedYearFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->stateFilter = '';
        $this->companyFilter = '';
        $this->investmentFilter = '';
        $this->yearFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $projects = Project::with('company')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('pda_code', 'like', '%' . $this->search . '%')
                        ->orWhereHas('company', function ($companyQuery) {
                            $companyQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->stateFilter, function ($query) {
                $query->where('state', $this->stateFilter);
            })
            ->when($this->companyFilter, function ($query) {
                $query->where('company_id', $this->companyFilter);
            })
            ->when($this->investmentFilter, function ($query) {
                $query->where('investments', $this->investmentFilter);
            })
            ->when($this->yearFilter, function ($query) {
                $query->whereYear('start_date', $this->yearFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $companies = \App\Models\Company::orderBy('name')->get();
        $states = ['Planification', 'Execution', 'Finished'];
        $investments = [
            'Innovation',
            'Efficiency & Saving',
            'Replacement & Restructuring',
            'Quality & Hygiene',
            'Health & Safety',
            'Environment',
            'Maintenance',
            'Capacity Increase'
        ];

        // Obtener años únicos de los proyectos para el filtro
        $years = Project::selectRaw('YEAR(start_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->filter() // Remover valores nulos
            ->values();

        return view('livewire.projects-page', compact('projects', 'companies', 'states', 'investments', 'years'));
    }
}
