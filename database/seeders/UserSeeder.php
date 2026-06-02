<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'staff']);
        Role::firstOrCreate(['name' => 'manager']);
        Role::firstOrCreate(['name' => 'admin']);
        $employee = Employee::create([
            'code'  => 'EMP-001',
            'name'  => 'admin',
            'email' => 'admin@taskment.com'
        ]);

        $admin = User::firstOrCreate(
            [
                'email'         => 'admin@taskment.com',
                'employee_id'   => '1'
            ],
            [
                'name'          => 'admin',
                'password'      => bcrypt('admin123')
            ]
        );
        $admin->assignRole('manager');
    }
}
