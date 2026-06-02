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
            'code'  => 'EMP-001',
            'name'  => 'admin',
            'email' => 'admin@taskment.com'
        ]);        

        $admin = User::firstOrCreate(
            [
                'email'         => 'staff@taskment.com',
                'employee_id'   => '1'
            ],
            [
                'name'          => 'staff',
                'password'      => bcrypt('admin123')
            ]
        );
        $admin->assignRole('staff');
    }
}
