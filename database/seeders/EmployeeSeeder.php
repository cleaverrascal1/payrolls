<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positionIds = Position::pluck('id')->toArray();

        $employees = [
            [
                'name' => 'Alexander Asep',
                'address' => 'Jl. Sudirman No. 12, Jakarta',
            ],
            [
                'name' => 'Muhammad Rizky',
                'address' => 'Jl. Asia Afrika No. 45, Bandung',
            ],
            [
                'name' => 'Andi Pratama',
                'address' => 'Jl. Diponegoro No. 8, Surabaya',
            ],
            [
                'name' => 'Budi Santoso',
                'address' => 'Jl. Ahmad Yani No. 22, Semarang',
            ],
            [
                'name' => 'Dimas Saputra',
                'address' => 'Jl. Gatot Subroto No. 17, Bekasi',
            ],
            [
                'name' => 'Fajar Hidayat',
                'address' => 'Jl. Merdeka No. 5, Bogor',
            ],
            [
                'name' => 'Rizal Maulana',
                'address' => 'Jl. Veteran No. 31, Depok',
            ],
            [
                'name' => 'Naufal Ramadhan',
                'address' => 'Jl. Pemuda No. 14, Tangerang',
            ],
            [
                'name' => 'Yoga Prasetyo',
                'address' => 'Jl. Cendana No. 9, Yogyakarta',
            ],
            [
                'name' => 'Ilham Akbar',
                'address' => 'Jl. Pahlawan No. 27, Malang',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::create([
                'name' => $employee['name'],
                'position_id' => !empty($positionIds)
                    ? $positionIds[array_rand($positionIds)]
                    : null,
                'address' => $employee['address'],
            ]);
        }
    }
}
