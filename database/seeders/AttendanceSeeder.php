<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();

        if ($employees->isEmpty()) {
            return;
        }

        foreach ($employees as $employee) {

            $date = Carbon::create(now()->year, 5, 1);
            $endDate = Carbon::today();

            while ($date->lte($endDate)) {

                if (!$date->isWeekend()) {

                    $random = rand(1, 100);

                    $hadir = false;
                    $izin = false;
                    $sakit = false;
                    $alpa = false;

                    if ($random <= 88) {
                        $hadir = true;
                    } elseif ($random <= 93) {
                        $izin = true;
                    } elseif ($random <= 98) {
                        $sakit = true;
                    } else {
                        $alpa = true;
                    }

                    Attendance::create([
                        'id' => Str::uuid(),
                        'employee_id' => $employee->id,
                        'date' => $date->toDateString(),
                        'hadir' => $hadir,
                        'izin' => $izin,
                        'sakit' => $sakit,
                        'alpa' => $alpa,
                    ]);
                }

                $date->addDay();
            }
        }
    }
}
