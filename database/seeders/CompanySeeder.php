<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name' => 'CIESA',
                'slug' => 'ciesa',
                'description' => 'Empresa líder en soluciones tecnológicas y desarrollo de software.',
                'code' => 'CIESA001',
                'active' => true,
            ],
            [
                'name' => 'SEAFMAN',
                'slug' => 'seafman',
                'description' => 'Corporación multinacional especializada en proyectos industriales.',
                'code' => 'SEAFMAN002',
                'active' => true,
            ],
            [
                'name' => 'GRALCO',
                'slug' => 'gralco',
                'description' => 'Compañía de consultoría e innovación en procesos empresariales.',
                'code' => 'GRALCO003',
                'active' => true,
            ]
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }

        // $this->command->info('✅ 3 compañías creadas exitosamente:');
        // $this->command->info('   - Tech Solutions Inc. (TECH001)');
        // $this->command->info('   - Global Industries Corp. (GLOB002)');
        // $this->command->info('   - Innovation Partners Ltd. (INNO003)');
    }
}
