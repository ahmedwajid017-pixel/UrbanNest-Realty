<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Owner']);
        Role::firstOrCreate(['name' => 'Agent']);
        Role::firstOrCreate(['name' => 'Staff']);
    }
}
