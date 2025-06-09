<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AvailabilityController extends Controller
{
    public function index(): Response
    {
        $availabilities = auth()->user()->availabilities()->orderBy('weekday')->orderBy('start_time')->get();
        return Inertia::render('Availabilities/Index', [
            'availabilities' => $availabilities,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Availabilities/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'weekday' => 'required|integer|min:0|max:6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        $data['user_id'] = auth()->id();
        Availability::create($data);
        return redirect()->route('availabilities.index')->with('success', 'Disponibilidade criada com sucesso!');
    }

    public function edit(Availability $availability): Response
    {
        if ($availability->user_id !== auth()->id()) {
            abort(403);
        }
        return Inertia::render('Availabilities/Edit', [
            'availability' => $availability,
        ]);
    }

    public function update(Request $request, Availability $availability)
    {
        if ($availability->user_id !== auth()->id()) {
            abort(403);
        }
        $data = $request->validate([
            'weekday' => 'required|integer|min:0|max:6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        $availability->update($data);
        return redirect()->route('availabilities.index')->with('success', 'Disponibilidade atualizada com sucesso!');
    }

    public function destroy(Availability $availability)
    {
        if ($availability->user_id !== auth()->id()) {
            abort(403);
        }
        $availability->delete();
        return redirect()->route('availabilities.index')->with('success', 'Disponibilidade removida com sucesso!');
    }
} 