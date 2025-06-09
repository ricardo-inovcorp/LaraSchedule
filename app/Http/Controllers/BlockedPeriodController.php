<?php

namespace App\Http\Controllers;

use App\Models\BlockedPeriod;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BlockedPeriodController extends Controller
{
    public function index(): Response
    {
        $blockedPeriods = auth()->user()->blockedPeriods()->orderByDesc('start_date')->get();
        return Inertia::render('BlockedPeriods/Index', [
            'blockedPeriods' => $blockedPeriods,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('BlockedPeriods/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'motivo' => 'nullable|string|max:255',
        ]);
        $data['user_id'] = auth()->id();
        BlockedPeriod::create($data);
        return redirect()->route('blocked-periods.index')->with('success', 'Período bloqueado criado com sucesso!');
    }

    public function edit(BlockedPeriod $blockedPeriod): Response
    {
        if ($blockedPeriod->user_id !== auth()->id()) {
            abort(403);
        }
        return Inertia::render('BlockedPeriods/Edit', [
            'blockedPeriod' => $blockedPeriod,
        ]);
    }

    public function update(Request $request, BlockedPeriod $blockedPeriod)
    {
        if ($blockedPeriod->user_id !== auth()->id()) {
            abort(403);
        }
        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'motivo' => 'nullable|string|max:255',
        ]);
        $blockedPeriod->update($data);
        return redirect()->route('blocked-periods.index')->with('success', 'Período bloqueado atualizado com sucesso!');
    }

    public function destroy(BlockedPeriod $blockedPeriod)
    {
        if ($blockedPeriod->user_id !== auth()->id()) {
            abort(403);
        }
        $blockedPeriod->delete();
        return redirect()->route('blocked-periods.index')->with('success', 'Período bloqueado removido com sucesso!');
    }
} 