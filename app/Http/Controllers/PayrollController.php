<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payroll\CreatePayrollRequest;
use App\Http\Requests\Payroll\UpdatePayrollRequest;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Attendance;
use ZipStream\ZipStream;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payrolls = Payroll::with('employee')
            ->when($request->search, fn($q) => $q->whereHas('employee', fn($q) =>
            $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->search) . '%'])
            ))
            ->when($request->position, fn($q) => $q->where('position', $request->position))
            ->when($request->monthly_period, fn($q) => $q->where('monthly_period', $request->monthly_period))
            ->when($request->year_period, fn($q) => $q->where('year_period', $request->year_period))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $positions = Position::orderBy('name')->pluck('name');

        return view('payrolls.index', compact('payrolls', 'positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();

        return view('payrolls.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePayrollRequest $request)
    {
        DB::transaction(function () use ($request) {

            $employee = Employee::with('position')
                ->findOrFail($request->employee_id);

            $basicSalary = $employee->position->basic_salary;

            $defaultItems = [
                ['name' => 'Tabungan Wajib', 'type' => 'deduction', 'amount' => 100000],
            ];

            $allItems = array_merge($defaultItems, $request->payrollItems ?? []);

            $total = $basicSalary;
            foreach ($allItems as $item) {
                $total += $item['type'] === 'addition' ? $item['amount'] : -$item['amount'];
            }

            $payroll = Payroll::create([
                'employee_id'    => $employee->id,
                'position'       => $employee->position->name,
                'monthly_period' => $request->monthly_period,
                'year_period'    => $request->year_period,
                'payday'         => now()->toDateString(),
                'salary'         => $basicSalary,
                'total'          => $total,
                'status'         => 'pending',
            ]);

            foreach ($allItems as $item) {
                $payroll->payrollItems()->create([
                    'name'   => $item['name'],
                    'type'   => $item['type'],
                    'amount' => $item['amount'],
                ]);
            }
        });

        return redirect()->route('payrolls.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payroll = Payroll::with(['employee', 'payrollItems'])->findOrFail($id);

        $attendances = \App\Models\Attendance::where('employee_id', $payroll->employee_id)
            ->whereMonth('date', $payroll->monthly_period)
            ->whereYear('date', $payroll->year_period)
            ->get();

        return view('payrolls.show', compact('payroll', 'attendances'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payroll = Payroll::with(['employee', 'payrollItems'])->findOrFail($id);
        $employees = Employee::all();

        return view('payrolls.edit', compact('payroll', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePayrollRequest $request, string $id)
    {
        DB::transaction(function () use ($request, $id) {

            $payroll = Payroll::findOrFail($id);

            $employee = Employee::with('position')->findOrFail($request->employee_id);
            $basicSalary = $employee->position->basic_salary;

            $total = $basicSalary;
            foreach ($request->payrollItems ?? [] as $item) {
                $total += $item['type'] === 'addition' ? $item['amount'] : -$item['amount'];
            }

            $payroll->update([
                'employee_id'    => $employee->id,
                'position'       => $employee->position->name,
                'monthly_period' => $request->monthly_period,
                'year_period'    => $request->year_period,
                'salary'         => $basicSalary,
                'total'          => $total,
            ]);

            $payroll->payrollItems()->delete();

            foreach ($request->payrollItems ?? [] as $item) {
                $payroll->payrollItems()->create([
                    'name'   => $item['name'],
                    'type'   => $item['type'],
                    'amount' => $item['amount'],
                ]);
            }
        });

        return redirect()->route('payrolls.index');
    }

    public function generateBulk(Request $request)
    {
        $request->validate([
            'monthly_period' => 'required|integer|between:1,12',
            'year_period'    => 'required|integer|digits:4',
        ]);

        $monthly = $request->monthly_period;
        $yearly  = $request->year_period;

        $existingIds = Payroll::where('monthly_period', $monthly)
            ->where('year_period', $yearly)
            ->pluck('employee_id');

        $employees = Employee::with('position')
            ->whereNotIn('id', $existingIds)
            ->get();

        if ($employees->isEmpty()) {
            return redirect()->route('payrolls.index')
                ->with('info', 'Semua pegawai sudah memiliki payroll untuk periode ini.');
        }

        DB::transaction(function () use ($employees, $monthly, $yearly) {
            $defaultItems = [
                ['name' => 'Tabungan Wajib', 'type' => 'deduction', 'amount' => 100000],
            ];

            foreach ($employees as $employee) {
                $basicSalary = $employee->position->basic_salary ?? 0;

                $total = $basicSalary;
                foreach ($defaultItems as $item) {
                    $total += $item['type'] === 'addition' ? $item['amount'] : -$item['amount'];
                }

                $payroll = Payroll::create([
                    'employee_id'    => $employee->id,
                    'position'       => $employee->position->name ?? '-',
                    'monthly_period' => $monthly,
                    'year_period'    => $yearly,
                    'payday'         => now()->toDateString(),
                    'salary'         => $basicSalary,
                    'total'          => $total,
                    'status'         => 'pending',
                ]);

                foreach ($defaultItems as $item) {
                    $payroll->payrollItems()->create($item);
                }
            }
        });

        return redirect()->route('payrolls.index')
            ->with('success', 'Payroll berhasil dibuat.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function downloadBatch(Request $request)
    {
        $request->validate([
            'monthly_period' => 'required|integer|between:1,12',
            'year_period'    => 'required|integer|min:2000',
        ]);

        $month = $request->monthly_period;
        $year  = $request->year_period;

        $payrolls = \App\Models\Payroll::with(['employee', 'payrollItems'])
            ->where('monthly_period', $month)
            ->where('year_period', $year)
            ->get();

        if ($payrolls->isEmpty()) {
            return back()->with('info', 'Tidak ada slip gaji untuk periode tersebut.');
        }

        return response()->stream(function () use ($payrolls, $month, $year) {
            $zip = new ZipStream(outputName: "slip-gaji-{$month}-{$year}.zip");

            foreach ($payrolls as $payroll) {
                $attendances = \App\Models\Attendance::where('employee_id', $payroll->employee_id)
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->get();

                $pdf = Pdf::loadView('payrolls.slip-pdf', compact('payroll', 'attendances'));

                $filename = 'slip-' . str($payroll->employee->name)->slug() . '-' . $month . '-' . $year . '.pdf';
                $zip->addFile($filename, $pdf->output());
            }

            $zip->finish();
        }, 200, [
            'Content-Type'        => 'application/zip',
            'Content-Disposition' => "attachment; filename=\"slip-gaji-{$month}-{$year}.zip\"",
        ]);
    }

    public function download(string $id)
    {
        $payroll = Payroll::with(['employee', 'payrollItems'])->findOrFail($id);

        $attendances = Attendance::where('employee_id', $payroll->employee_id)
            ->whereMonth('date', $payroll->monthly_period)
            ->whereYear('date', $payroll->year_period)
            ->get();

        $logoPath   = public_path('images/logo.png');
        $logoBase64 = base64_encode(file_get_contents($logoPath));
        $logoSrc    = 'data:image/png;base64,' . $logoBase64;

        $pdf = Pdf::loadView('payrolls.slip-single', compact('payroll', 'attendances', 'logoSrc'))
            ->setPaper('a4', 'portrait');

        $filename = 'slip-' . str($payroll->employee->name)->slug() . '-' . $payroll->monthly_period . '-' . $payroll->year_period . '.pdf';

        return $pdf->download($filename);
    }
}
