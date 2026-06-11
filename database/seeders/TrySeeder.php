<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\User;
use App\Models\Vendor;

class TrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendor = Vendor::create([
            'code'      => 'VND-001',
            'name'      => 'PT Khayahan Persada',
            'address'   => 'jln. Tondano 1 Block C23',
            'email'     => 'admin@kp.co.id'
        ]);
        
        $employee = Employee::create([
            'code'  => 'EMP-002',
            'name'  => 'staff',
            'email' => 'staff@taskment.com'
        ]);        

        $admin = User::firstOrCreate(
            [
                'email'         => 'staff@taskment.com',
                'employee_id'   => '2'
            ],
            [
                'name'          => 'staff',
                'password'      => bcrypt('admin123')
            ]
        );
        $admin->assignRole('staff');

        $employee = Employee::create([
            'code'  => 'EMP-003',
            'name'  => 'manager',
            'email' => 'manager@taskment.com'
        ]);        

        $admin = User::firstOrCreate(
            [
                'email'         => 'manager@taskment.com',
                'employee_id'   => '3'
            ],
            [
                'name'          => 'manager',
                'password'      => bcrypt('admin123')
            ]
        );
        $admin->assignRole('manager');
    }
}
