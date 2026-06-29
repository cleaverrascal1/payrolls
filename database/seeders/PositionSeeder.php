<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                'position' => [
                    'name' => 'Marketing Junior',
                    'basic_salary' => 2000000,
                    'sales_target' => 4000000,
                ],
                'bonusRules' => [
                    ['min_percentage' => 80, 'max_percentage' => 99, 'bonus' => 250000],
                    ['min_percentage' => 100, 'max_percentage' => 119, 'bonus' => 500000],
                    ['min_percentage' => 120, 'max_percentage' => null, 'bonus' => 750000],
                ],
                'performanceBonuses' => [],
                'penalties' => [],
            ],
            [
                'position' => [
                    'name' => 'Marketing Senior',
                    'basic_salary' => 2500000,
                    'sales_target' => 6000000,
                ],
                'bonusRules' => [
                    ['min_percentage' => 80, 'max_percentage' => 99, 'bonus' => 500000],
                    ['min_percentage' => 100, 'max_percentage' => 119, 'bonus' => 1000000],
                    ['min_percentage' => 120, 'max_percentage' => null, 'bonus' => 1500000],
                ],
                'performanceBonuses' => [],
                'penalties' => [],
            ],
            [
                'position' => [
                    'name' => 'Leader Marketing',
                    'basic_salary' => 3000000,
                    'sales_target' => 8000000,
                ],
                'bonusRules' => [
                    ['min_percentage' => 80, 'max_percentage' => 99, 'bonus' => 500000],
                    ['min_percentage' => 100, 'max_percentage' => 119, 'bonus' => 1000000],
                    ['min_percentage' => 120, 'max_percentage' => null, 'bonus' => 1500000],
                ],
                'performanceBonuses' => [],
                'penalties' => [],
            ],
            [
                'position' => [
                    'name' => 'Kepala Divisi Marketing',
                    'basic_salary' => 3000000,
                    'sales_target' => null,
                ],
                'bonusRules' => [
                    ['min_percentage' => 80, 'max_percentage' => 99, 'bonus' => 1000000],
                    ['min_percentage' => 100, 'max_percentage' => 109, 'bonus' => 1500000],
                    ['min_percentage' => 110, 'max_percentage' => null, 'bonus' => 2000000],
                ],
                'performanceBonuses' => [
                    ['name' => 'Kualitas Tim Terjaga', 'amount' => 500000],
                    ['name' => 'Sistem Berjalan Baik', 'amount' => 500000],
                ],
                'penalties' => [
                    ['name' => 'Manipulasi Data', 'type' => 'void', 'value' => 0],
                    ['name' => 'Tim Tidak Stabil', 'type' => 'percentage', 'value' => 50],
                    ['name' => 'Banyak Komplain', 'type' => 'percentage', 'value' => 50],
                    ['name' => 'Sistem Tidak Jalan', 'type' => 'void', 'value' => 0],
                ],
            ],
            [
                'position' => [
                    'name' => 'Layanan Junior',
                    'basic_salary' => 2000000,
                    'sales_target' => 30000000,
                ],
                'bonusRules' => [
                    ['min_percentage' => 80, 'max_percentage' => 99, 'bonus' => 500000],
                    ['min_percentage' => 100, 'max_percentage' => 119, 'bonus' => 1000000],
                    ['min_percentage' => 120, 'max_percentage' => null, 'bonus' => 1500000],
                ],
                'performanceBonuses' => [],
                'penalties' => [],
            ],
            [
                'position' => [
                    'name' => 'Layanan Senior',
                    'basic_salary' => 3000000,
                    'sales_target' => 40000000,
                ],
                'bonusRules' => [
                    ['min_percentage' => 80, 'max_percentage' => 99, 'bonus' => 500000],
                    ['min_percentage' => 100, 'max_percentage' => 119, 'bonus' => 1000000],
                    ['min_percentage' => 120, 'max_percentage' => null, 'bonus' => 1500000],
                ],
                'performanceBonuses' => [],
                'penalties' => [],
            ],
            [
                'position' => [
                    'name' => 'Kepala Divisi Layanan',
                    'basic_salary' => 3000000,
                    'sales_target' => null,
                ],
                'bonusRules' => [
                    ['min_percentage' => 0, 'max_percentage' => 89, 'bonus' => 0],
                    ['min_percentage' => 90, 'max_percentage' => 99, 'bonus' => 1500000],
                    ['min_percentage' => 100, 'max_percentage' => 109, 'bonus' => 2000000],
                    ['min_percentage' => 110, 'max_percentage' => null, 'bonus' => 2500000],
                ],
                'performanceBonuses' => [
                    ['name' => 'Kualitas Tim Terjaga', 'amount' => 750000],
                    ['name' => 'Sistem Berjalan Baik', 'amount' => 750000],
                ],
                'penalties' => [
                    ['name' => 'Manipulasi Data', 'type' => 'void', 'value' => 0],
                    ['name' => 'Tim Tidak Stabil', 'type' => 'percentage', 'value' => 50],
                    ['name' => 'Banyak Komplain', 'type' => 'percentage', 'value' => 50],
                    ['name' => 'Sistem Tidak Jalan', 'type' => 'void', 'value' => 0],
                ],
            ],
            [
                'position' => [
                    'name'         => 'Software Developer',
                    'basic_salary' => 5000000,
                    'sales_target' => null,
                ],
                'bonusRules'         => [],
                'performanceBonuses' => [],
                'penalties'          => [],
            ],
            [
                'position' => [
                    'name'         => 'Staff Administrasi',
                    'basic_salary' => 3000000,
                    'sales_target' => null,
                ],
                'bonusRules'         => [],
                'performanceBonuses' => [],
                'penalties'          => [],
            ],
            [
                'position' => [
                    'name'         => 'Staff Keuangan',
                    'basic_salary' => 3500000,
                    'sales_target' => null,
                ],
                'bonusRules'         => [],
                'performanceBonuses' => [],
                'penalties'          => [],
            ],
            [
                'position' => [
                    'name'         => 'HRD',
                    'basic_salary' => 4000000,
                    'sales_target' => null,
                ],
                'bonusRules'         => [],
                'performanceBonuses' => [],
                'penalties'          => [],
            ],
            [
                'position' => [
                    'name'         => 'Staff Operasional',
                    'basic_salary' => 2800000,
                    'sales_target' => null,
                ],
                'bonusRules'         => [],
                'performanceBonuses' => [],
                'penalties'          => [],
            ],
            [
                'position' => [
                    'name'         => 'Supervisor',
                    'basic_salary' => 4500000,
                    'sales_target' => null,
                ],
                'bonusRules'         => [],
                'performanceBonuses' => [],
                'penalties'          => [],
            ],
            [
                'position' => [
                    'name'         => 'Manager',
                    'basic_salary' => 6000000,
                    'sales_target' => null,
                ],
                'bonusRules'         => [],
                'performanceBonuses' => [],
                'penalties'          => [],
            ],
            [
                'position' => [
                    'name'         => 'Customer Service',
                    'basic_salary' => 2500000,
                    'sales_target' => null,
                ],
                'bonusRules'         => [],
                'performanceBonuses' => [],
                'penalties'          => [],
            ],
            [
                'position' => [
                    'name'         => 'IT Support',
                    'basic_salary' => 3200000,
                    'sales_target' => null,
                ],
                'bonusRules'         => [],
                'performanceBonuses' => [],
                'penalties'          => [],
            ],
        ];

        foreach ($positions as $data) {
            $position = Position::updateOrCreate(
                ['name' => $data['position']['name']],
                $data['position']
            );

            $position->bonusRules()->delete();
            foreach ($data['bonusRules'] as $rule) {
                $position->bonusRules()->create($rule);
            }

            $position->performanceBonuses()->delete();
            foreach ($data['performanceBonuses'] as $bonus) {
                $position->performanceBonuses()->create($bonus);
            }

            $position->penalties()->delete();
            foreach ($data['penalties'] as $penalty) {
                $position->penalties()->create($penalty);
            }
        }
    }
}
