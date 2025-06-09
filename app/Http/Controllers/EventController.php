<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    public function index(): Response
    {
        $events = auth()->user()->events()->latest()->get();
        return Inertia::render('Events/Index', [
            'events' => $events,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Events/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
        ]);
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        $event = Event::create($data);
        return redirect()->route('events.index')->with('success', 'Evento criado com sucesso!');
    }

    public function edit(Event $event): Response
    {
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }
        return Inertia::render('Events/Edit', [
            'event' => $event,
        ]);
    }

    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
        ]);
        $event->update($data);
        return redirect()->route('events.index')->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Event $event)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Evento removido com sucesso!');
    }
} 