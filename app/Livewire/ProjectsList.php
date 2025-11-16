<?php

namespace App\Livewire;

use App\Exports\ProjectExport;
use App\Exports\DataExport;
use App\Models\Project;
use App\Models\Data;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;

class ProjectsTable extends Component
{
    use WithPagination;

    public $perPage = 20;

    #[Url()]
    public $search = '';

    public $sortBy = 'id';
    public $sortDir = 'DESC';

    public $is_admin_user = false;
    public $active = false;
    public $yearSearch = "all";
    public $years = 0;
    public $stateProject = [];
    public $typeOfProject = [];
    public $typeOfProjectSearch = "all";
    public $stateSearch;
    public $orderByProject = false; // Propiedad para controlar el ordenamiento
    public $textButton = "Order by Rest";

    public function mount($is_admin, $active)
    {
        $this->is_admin_user = $is_admin;
        $this->active = $active;

        $this->years = $this->getYears();
        $this->stateProject = $this->getDiferentValues('state');
        $this->typeOfProject = $this->getDiferentValues('classification_of_investments');
        $this->stateSearch = "all";
    }

    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir === "ASC") ? 'DESC' : 'ASC';
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function export()
    {
        // return Excel::download(new ProjectExport, 'projects.xlsx');
        return true;
    }

    public function dataExport()
    {
        // return Excel::download(new DataExport(), 'data_export.xlsx');
        return true;
    }

    public function resetAll()
    {
        // Restablecer todos los valores relevantes a sus estados iniciales
        $this->search = ''; // Restablece la búsqueda
        // Aquí puedes restablecer otras variables que necesites
        $this->yearSearch = 'all'; // Por ejemplo, restablecer el año
        $this->stateSearch = 'all'; // Restablecer el estado
        $this->typeOfProjectSearch = 'all'; // Restablecer el tipo de proyecto
        $this->orderByProject = false; // O cualquier otra variable que necesites restablecer

        // Opcional: puedes recargar los proyectos o realizar cualquier otra acción necesaria
        $this->resetPage(); // Resetea la página actual de paginación
    }


    public function projectOrder()
    {
        // Cambia el estado de orderByProject a verdadero
        $this->orderByProject = !$this->orderByProject; // O puedes alternarlo según tus necesidades
        $this->textButton = "Clear Order";
    }


    public function render()
    {
        // Comienza la consulta en la tabla data
        $query = Data::select('project_id')
            ->selectRaw('SUM(booked_euros) as total_booked_euros')
            ->selectRaw('SUM(global_price_euros) as total_global_price_euros')
            ->selectRaw('(SUM(global_price_euros) - SUM(booked_euros)) as rest') // Agrega el campo rest
            ->groupBy('project_id')
            ->orderBy('rest', 'DESC'); // Ordena por el campo rest de mayor a menor

        // Obtén los resultados
        $dataResults = $query->get();

        // Genera el array con los resultados resumidos
        $dataArray = [];
        foreach ($dataResults as $data) {
            $dataArray[] = [
                'project_id' => $data->project_id,
                'executed_euros' => $data->total_executed_euros,
                'global_price_euros' => $data->total_global_price_euros,
                'rest' => $data->rest, // Agrega el campo rest al array
            ];
        }

        // Mostrar el resultado con dd para depuración
        // dd($dataArray);

        $yearSearch = $this->yearSearch;

        // Comienza la consulta con la búsqueda
        $query = Project::search($this->search)
            ->when($this->yearSearch !== 'all', function ($query) {
                return $query->whereYear('start_date', $this->yearSearch);
            })
            ->when($this->stateSearch !== 'all', function ($query) {
                return $query->where('state', $this->stateSearch);
            })
            ->when($this->typeOfProjectSearch !== 'all', function ($query) {
                return $query->where('classification_of_investments', $this->typeOfProjectSearch);
            });

        if ($this->orderByProject) {
            // Filtrar los proyectos para incluir solo aquellos que están en el dataArray
            $projectIds = array_column($dataArray, 'project_id'); // Obtiene solo los project_id

            // Asegúrate de que hay project_ids para evitar errores en la consulta
            if (!empty($projectIds)) {
                $query->whereIn('id', $projectIds) // Filtra los proyectos
                    ->where('state', '!=', 'Finished')
                    ->orderByRaw("FIELD(id, " . implode(',', $projectIds) . ")"); // Mantiene el orden de dataArray
            } else {
                $query->whereRaw('1=0'); // No devuelve resultados si no hay project_ids
            }
        } else {
            // Si no se aplica el join, ordena normalmente por el campo definido
            $query->orderBy($this->sortBy, $this->sortDir);
        }

        // Paginación
        $projects = $query->paginate($this->perPage);

        return view(
            'livewire.projects-list',
            [
                'projects' => $projects
            ]
        );
    }


    public function refresh()
    {
        return view(
            'livewire.projects-list',
            [
                'projects' => Project::search($this->search)
                    ->when($this->yearSearch !== 'all', function ($query) {
                        return $query->whereYear('start_date', $this->yearSearch);
                    })
                    ->when($this->stateSearch !== 'all', function ($query) {
                        return $query->where('state', $this->stateSearch);
                    })->when($this->typeOfProjectSearch !== 'all', function ($query) {
                        return $query->where('classification_of_investments', $this->typeOfProjectSearch);
                    })
                    ->orderBy($this->sortBy, $this->sortDir)
                    ->paginate($this->perPage)
            ]
        );
    }

    public function updated($property, $value)
    {

        if ($property === "typeOfProjectSearch") {
            $this->stateProject = Project::distinct()
                ->where('data_uploaded', 1)
                ->when($value !== 'all', function ($query) use ($value) {
                    return $query->where('projects.classification_of_investments', $value);
                })
                ->when($this->yearSearch !== 'all', function ($query) {
                    return $query->whereRaw('YEAR(projects.start_date) = ?', [$this->yearSearch]);
                })
                ->pluck('state');
        }

        if ($property === "stateSearch") {
            $this->typeOfProject = Project::distinct()
                ->where('data_uploaded', 1)
                ->when($value !== 'all', function ($query) use ($value) {
                    return $query->where('projects.state', $value);
                })
                ->when($this->yearSearch !== 'all', function ($query) {
                    return $query->whereRaw('YEAR(projects.start_date) = ?', [$this->yearSearch]);
                })
                ->pluck('classification_of_investments');
        }

        if ($property === "yearSearch") {
            $this->stateProject = Project::distinct()
                ->where('data_uploaded', 1)
                ->when($value !== 'all', function ($query) use ($value) {
                    return $query->whereRaw('YEAR(projects.start_date) = ?', [$value]);
                })
                ->pluck('state');

            $this->typeOfProject = Project::distinct()
                ->where('data_uploaded', 1)
                ->when($value !== 'all', function ($query) use ($value) {
                    return $query->whereRaw('YEAR(projects.start_date) = ?', [$value]);
                })
                ->pluck('classification_of_investments');
        }

        // if ($property === "dollarOrEuro" && $value === "dollar") {
        //     $this->exchangeRate = (float)(1 / (float)$this->rateValue);
        // } else {
        //     $this->exchangeRate = 1;
        // }
    }

    public function downloadPDA()
    {
        $projectData = Project::find($this->id);

        $filePath = $this->pdaPath . '/' . $projectData->file_name;

        // if (Storage::disk('local')->exists($filePath)) {
        //     return Storage::download($this->pdaPath . '/' . $projectData->file_name, "PDA_file.pdf");
        // }
    }

    public function getYears()
    {
        $uniqueYears = Project::where('data_uploaded', 1)
            ->distinct()
            ->get(['start_date'])
            ->pluck('start_date')
            ->map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('Y');
            })
            ->unique();

        return $uniqueYears->sortDesc();
    }

    public function getDiferentValues($column)
    {
        return Project::distinct()
            ->where('data_uploaded', 1)
            ->pluck($column);
    }

    public function placeholder()
    {
        return <<<'HTML'
                <div class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-stone-200">
                    <div class="p-4 rounded">
                        <p class="text-3xl font-extrabold">Loading....</p>
                    </div>
                </div>
        HTML;
    }
}
