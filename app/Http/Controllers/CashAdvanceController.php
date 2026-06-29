<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashAdvance\CreateCashAdvanceRequest;
use App\Models\CashAdvance;
use App\Models\Employee;
use Illuminate\Http\Request;

class CashAdvanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cashAdvances = CashAdvance::with('employee')
            ->when($request->search, fn($q) => $q->whereHas('employee', fn($q) => $q
                ->whereRaw('LOWER(name) LIKE ?', ["%" . strtolower($request->search) . "%"])
            ))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('cash-advances.index', compact('cashAdvances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();

        return view('cash-advances.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCashAdvanceRequest $request)
    {
        $cashAdvance = $request->validated();

        CashAdvance::create([
            ...$request->validated(),
            'remaining_amount' => $request->amount,
            'date' => now()->toDateTimeString()
        ]);

        return redirect()->route('cash-advances.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
