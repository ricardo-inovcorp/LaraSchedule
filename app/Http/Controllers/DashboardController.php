<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use App\Models\BlockedPeriod;
use App\Models\Event;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $hoje = now()->toDateString();
        $now = now();

        $totalAgendamentos = Appointment::where('user_id', $user->id)
            ->where('start_datetime', '>=', $now)
            ->count();

        $horariosDisponiveisHoje = Availability::where('user_id', $user->id)
            ->where('weekday', $now->dayOfWeek)
            ->count();

        $bloqueiosAtivos = BlockedPeriod::where('user_id', $user->id)
            ->where('start_date', '<=', $hoje)
            ->where('end_date', '>=', $hoje)
            ->count();

        $proximosAgendamentos = Appointment::where('user_id', $user->id)
            ->where('start_datetime', '>=', $now)
            ->orderBy('start_datetime')
            ->take(5)
            ->get(['id', 'event_id', 'start_datetime', 'name']);

        // Dados para gráficos (exemplo: agendamentos por semana)
        $agendamentosPorSemana = Appointment::where('user_id', $user->id)
            ->where('start_datetime', '>=', $now->copy()->subWeeks(6))
            ->get()
            ->groupBy(function($item) { return Carbon::parse($item->start_datetime)->format('W/Y'); })
            ->map->count();

        // Distribuição dos tipos de eventos
        $eventos = Event::where('user_id', $user->id)->get();
        $tipos = $eventos->groupBy('type')->map->count();

        return Inertia::render('Dashboard', [
            'totalAgendamentos' => $totalAgendamentos,
            'horariosDisponiveisHoje' => $horariosDisponiveisHoje,
            'bloqueiosAtivos' => $bloqueiosAtivos,
            'proximosAgendamentos' => $proximosAgendamentos,
            'agendamentosPorSemana' => $agendamentosPorSemana,
            'distribuicaoTiposEventos' => $tipos,
        ]);
    }
} 