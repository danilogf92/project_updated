<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(CompanySeeder::class);

        $this->call(ProjectSeeder::class);

        $this->call(DataSeeder::class);

        User::factory()->create([
            'name' => 'Danilo Granda',
            'email' => 'danilogrnd@gmail.com',
            'is_admin' => true,
            'active' => true,
            'company_id' => 1,
            'email_verified_at' => null,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => null,
            'password' => Hash::make('DaniloAndres91'),
        ]);
    }
}
