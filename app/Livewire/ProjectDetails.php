<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Data;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectDetails extends Component
{
    use WithPagination;

    public $project;
    public $projectId;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function mount($projectId)
    {
        $this->projectId = $projectId;
        $this->project = Project::with('company')->findOrFail($projectId);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $dataRecords = Data::where('project_id', $this->projectId)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('description', 'like', '%' . $this->search . '%')
                        ->orWhere('area', 'like', '%' . $this->search . '%')
                        ->orWhere('group_1', 'like', '%' . $this->search . '%')
                        ->orWhere('group_2', 'like', '%' . $this->search . '%')
                        ->orWhere('supplier', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        // Calcular totales
        $totals = [
            'global_price' => Data::where('project_id', $this->projectId)->sum('global_price'),
            'global_price_euros' => Data::where('project_id', $this->projectId)->sum('global_price_euros'),
            'executed_dollars' => Data::where('project_id', $this->projectId)->sum('executed_dollars'),
            'executed_euros' => Data::where('project_id', $this->projectId)->sum('executed_euros'),
            'real_value' => Data::where('project_id', $this->projectId)->sum('real_value'),
            'booked' => Data::where('project_id', $this->projectId)->sum('booked'),
        ];

        return view('livewire.project-details', [
            'dataRecords' => $dataRecords,
            'totals' => $totals,
        ]);
    }
}
