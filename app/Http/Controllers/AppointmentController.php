<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function calendar()
    {
        $user = Auth::user();
        $appointments = Appointment::where('user_id', $user->id)->get();
        return Inertia::render('Appointments/Calendar', [
            'appointments' => $appointments,
        ]);
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return Inertia::render('Appointments/Show', [
            'appointment' => $appointment,
        ]);
    }

    public function approve($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'approved';
        $appointment->save();
        return redirect()->back()->with('success', 'Agendamento aprovado!');
    }

    public function reject($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'rejected';
        $appointment->save();
        return redirect()->back()->with('success', 'Agendamento recusado!');
    }
} 