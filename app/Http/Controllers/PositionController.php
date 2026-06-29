<?php

namespace App\Http\Controllers;

use App\Http\Requests\Position\CreatePositionRequest;
use App\Http\Requests\Position\UpdatePositionRequest;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $positions = Position::withCount(['employees', 'bonusRules', 'performanceBonuses', 'penalties'])
            ->when($request->search, fn($q) => $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->search) . '%']))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePositionRequest $request)
    {
        $validated = $request->validated();

        $position = Position::create([
            'name'         => $validated['name'],
            'basic_salary' => $validated['basic_salary'],
            'sales_target' => $validated['sales_target'] ?? null,
        ]);

        foreach ($validated['bonusRules'] ?? [] as $rule) {
            $position->bonusRules()->create($rule);
        }

        foreach ($validated['performanceBonuses'] ?? [] as $bonus) {
            $position->performanceBonuses()->create($bonus);
        }

        foreach ($validated['penalties'] ?? [] as $penalty) {
            $position->penalties()->create($penalty);
        }

        return redirect()->route('positions.index')
            ->with('success', "{$position->name} berhasil dibuat.");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $position = Position::with(['bonusRules', 'performanceBonuses', 'penalties'])->findOrFail($id);

        return view('positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $position = Position::with(['bonusRules', 'performanceBonuses', 'penalties'])->findOrFail($id);

        return view('positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePositionRequest $request, string $id)
    {
        $validated = $request->validated();

        $position = Position::findOrFail($id);

        $position->update([
            'name'         => $validated['name'],
            'basic_salary' => $validated['basic_salary'],
            'sales_target' => $validated['sales_target'] ?? null,
        ]);

        $position->bonusRules()->delete();
        foreach ($validated['bonusRules'] ?? [] as $rule) {
            $position->bonusRules()->create($rule);
        }

        $position->performanceBonuses()->delete();
        foreach ($validated['performanceBonuses'] ?? [] as $bonus) {
            $position->performanceBonuses()->create($bonus);
        }

        $position->penalties()->delete();
        foreach ($validated['penalties'] ?? [] as $penalty) {
            $position->penalties()->create($penalty);
        }

        return redirect()->route('positions.index')
            ->with('success', "{$position->name} berhasil diperbarui.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $position = Position::findOrFail($id);

        $position->delete();

        return redirect()->route('positions.index')
            ->with('success', "{$position->name} berhasil dihapus.");
    }
}
