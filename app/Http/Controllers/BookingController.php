<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Exibe a tela pública de agendamento
    public function show($slug): Response
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        // Carregar disponibilidades, bloqueios e agendamentos existentes
        $availabilities = $event->user->availabilities;
        $blockedPeriods = $event->user->blockedPeriods;
        $appointments = $event->appointments;
        $customFields = $event->customFields;
        return Inertia::render('Book/Show', [
            'event' => $event,
            'availabilities' => $availabilities,
            'blockedPeriods' => $blockedPeriods,
            'appointments' => $appointments,
            'customFields' => $customFields,
        ]);
    }

    // Processa o agendamento
    public function store(Request $request, $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            // Campos personalizados podem ser validados aqui se necessário
        ]);
        $data['event_id'] = $event->id;
        $data['user_id'] = $event->user_id;
        $data['status'] = 'pending';
        Appointment::create($data);
        return redirect()->back()->with('success', 'Agendamento realizado com sucesso!');
    }

    // Lista todos os eventos do usuário para exibir os links públicos
    public function index()
    {
        $events = auth()->user()->events()->get();
        return inertia('Book/Index', [
            'events' => $events,
        ]);
    }
} 