<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Data;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los proyectos existentes
        $projects = Project::with('company')->get();

        if ($projects->isEmpty()) {
            $this->command->warn('⚠️  No hay proyectos existentes. Ejecuta primero ProjectSeeder.');
            return;
        }

        $dataRecords = [];
        $recordCount = 0;

        // Áreas posibles
        $areas = ['Construction', 'Engineering', 'Procurement', 'Installation', 'Commissioning', 'Design'];

        // Grupos
        $groups1 = ['Civil Works', 'Mechanical', 'Electrical', 'Instrumentation', 'Piping', 'Structural'];
        $groups2 = ['Foundation', 'Equipment', 'Cabling', 'Control Systems', 'Pipes', 'Steel'];

        // Clasificaciones generales
        $classifications = ['Material', 'Labor', 'Equipment', 'Subcontract', 'Engineering', 'Management'];

        // Tipos de ítem
        $itemTypes = ['Concrete', 'Steel', 'Pipes', 'Valves', 'Pumps', 'Cables', 'Instruments', 'Panels'];

        // Unidades
        $units = ['m³', 'kg', 'm', 'pcs', 'hours', 'days', 'units'];

        // Etapas
        $stages = ['Planning', 'In Progress', 'Completed', 'On Hold', 'Cancelled'];

        // Proveedores
        $suppliers = ['Supplier A', 'Supplier B', 'Supplier C', 'Supplier D', 'Local Vendor', 'International Corp'];

        // Generar datos para cada proyecto
        foreach ($projects as $project) {
            // Entre 10-30 registros de data por proyecto
            $dataPerProject = rand(10, 30);

            for ($i = 1; $i <= $dataPerProject; $i++) {
                $qty = mt_rand(1, 1000);
                $unitPrice = mt_rand(100, 10000) / 100; // Precio unitario entre 1.00 y 100.00
                $globalPrice = $qty * $unitPrice;
                $globalPriceEuros = $globalPrice * $project->rate;

                // Porcentaje de ejecución (0-100%)
                $percentage = mt_rand(0, 100);

                // Calcular valores ejecutados basados en el porcentaje
                $executedDollars = $globalPrice * ($percentage / 100);
                $executedEuros = $globalPriceEuros * ($percentage / 100);

                // Valores reales y booked (pueden ser diferentes de los ejecutados)
                $realValue = $executedDollars * mt_rand(80, 120) / 100;
                $realValueEuros = $realValue * $project->rate;

                $booked = $executedDollars * mt_rand(90, 110) / 100;
                $bookedEuros = $booked * $project->rate;

                // Fechas de actualización (algunas pueden ser nulas)
                $realUpdatedAt = mt_rand(0, 1) ? Carbon::now()->subDays(mt_rand(1, 90))->format('Y-m-d') : null;
                $bookedUpdatedAt = mt_rand(0, 1) ? Carbon::now()->subDays(mt_rand(1, 90))->format('Y-m-d') : null;

                $dataRecords[] = [
                    'project_id' => $project->id,
                    'area' => $areas[array_rand($areas)],
                    'group_1' => $groups1[array_rand($groups1)],
                    'group_2' => $groups2[array_rand($groups2)],
                    'description' => "Item description for project {$project->pda_code} - {$i}",
                    'general_classification' => $classifications[array_rand($classifications)],
                    'item_type' => $itemTypes[array_rand($itemTypes)],
                    'unit' => $units[array_rand($units)],
                    'qty' => $qty,
                    'unit_price' => $unitPrice,
                    'global_price' => $globalPrice,
                    'global_price_euros' => $globalPriceEuros,
                    'stage' => $stages[array_rand($stages)],
                    'real_value' => $realValue,
                    'real_value_euros' => $realValueEuros,
                    'booked' => $booked,
                    'booked_euros' => $bookedEuros,
                    'percentage' => $percentage,
                    'executed_dollars' => $executedDollars,
                    'executed_euros' => $executedEuros,
                    'supplier' => $suppliers[array_rand($suppliers)],
                    'code' => "CODE-" . $project->pda_code . "-" . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'order_no' => "ORD-" . mt_rand(1000, 9999),
                    'input_num' => "INP-" . mt_rand(100, 999),
                    'observations' => mt_rand(0, 1) ? "Some observations for this item" : null,
                    'real_updated_at' => $realUpdatedAt,
                    'booked_updated_at' => $bookedUpdatedAt,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $recordCount++;

                // Insertar en lotes de 100 para mejor performance
                if (count($dataRecords) >= 100) {
                    Data::insert($dataRecords);
                    $dataRecords = [];
                }
            }
        }

        // Insertar registros restantes
        if (!empty($dataRecords)) {
            Data::insert($dataRecords);
        }

        $this->command->info('✅ Datos creados exitosamente:');
        $this->command->info("   - Total: " . $recordCount . " registros de data");
        $this->command->info("   - Por proyecto: " . $dataPerProject . " registros en promedio");

        // Mostrar estadísticas
        $totalGlobalPrice = Data::sum('global_price');
        $totalExecuted = Data::sum('executed_dollars');
        $completionPercentage = $totalGlobalPrice > 0 ? ($totalExecuted / $totalGlobalPrice) * 100 : 0;

        $this->command->info("   - Valor global total: $" . number_format($totalGlobalPrice, 2));
        $this->command->info("   - Valor ejecutado total: $" . number_format($totalExecuted, 2));
        $this->command->info("   - Porcentaje de completación general: " . number_format($completionPercentage, 1) . "%");

        // Mostrar resumen por proyecto
        foreach ($projects as $project) {
            $projectDataCount = Data::where('project_id', $project->id)->count();
            $projectGlobalPrice = Data::where('project_id', $project->id)->sum('global_price');
            $this->command->info("   - {$project->name}: {$projectDataCount} registros, $" . number_format($projectGlobalPrice, 2));
        }
    }
}
