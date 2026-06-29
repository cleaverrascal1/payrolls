<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = Employee::with('position')
            ->when($request->search, fn($q) => $q->where(fn($q) => $q
                ->whereRaw('LOWER(name) LIKE ?', ["%" . strtolower($request->search) . "%"])
                ->orWhereHas('position', fn($q) => $q->whereRaw('LOWER(name) LIKE ?', ["%" . strtolower($request->search) . "%"]))
            ))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $positions = Position::orderBy('name')->get();

        return view('employees.create', compact('positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEmployeeRequest $request)
    {
        $employee = $request->validated();

        Employee::create($employee);

        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with('position')->findOrFail($id);

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        $positions = Position::orderBy('name')->get();

        return view('employees.edit', compact('employee', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $employee->update($request->validated());

        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Employee::findOrFail($id)->delete();

        return redirect()->route('employees.index');
    }
}
