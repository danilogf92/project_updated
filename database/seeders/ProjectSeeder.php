<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las compañías existentes
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->warn('⚠️  No hay compañías existentes. Ejecuta primero CompanySeeder.');
            return;
        }

        $projects = [];

        // Estados posibles
        $states = ['Planification', 'Execution', 'Finished'];

        // Tipos de inversión
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

        // Clasificaciones de inversión
        $classifications = [
            'Buildings',
            'Furniture',
            'General Install',
            'Land',
            'Machines & Equipm',
            'Office Hardware Software',
            'Other',
            'Vehicles',
            'Vessel & Fishing Equipment',
            'Warenhouse & Distrib',
        ];

        // Justificaciones
        $justifications = ['Normal Capex', 'Special Project'];

        // Generar proyectos para cada compañía
        foreach ($companies as $company) {
            // Entre 3-5 proyectos por compañía
            $projectCount = rand(3, 5);

            for ($i = 1; $i <= $projectCount; $i++) {
                $startDate = Carbon::now()->subMonths(rand(1, 12));
                $finishDate = $startDate->copy()->addMonths(rand(6, 24));

                $projects[] = [
                    'company_id' => $company->id,
                    'name' => "Proyecto {$company->code}-{$i}",
                    'pda_code' => "PDA-{$company->code}-" . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'data_uploaded' => rand(0, 1),
                    'rate' => rand(95, 115) / 100, // Tasas entre 9.5 y 1.15
                    'state' => $states[array_rand($states)],
                    'investments' => $investments[array_rand($investments)],
                    'classification_of_investments' => $classifications[array_rand($classifications)],
                    'justification' => $justifications[array_rand($justifications)],
                    'start_date' => $startDate->format('Y-m-d'),
                    'finish_date' => $finishDate->format('Y-m-d'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insertar todos los proyectos
        Project::insert($projects);

        $this->command->info('✅ Proyectos creados exitosamente:');
        $this->command->info("   - Total: " . count($projects) . " proyectos");
        $this->command->info("   - Por compañía: " . $projectCount . " proyectos en promedio");

        // Mostrar resumen por compañía
        foreach ($companies as $company) {
            $companyProjects = Project::where('company_id', $company->id)->count();
            $this->command->info("   - {$company->name}: {$companyProjects} proyectos");
        }
    }
}
