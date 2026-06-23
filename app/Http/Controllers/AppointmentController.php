<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    // 🟢 GET: সব appointments list দেখাও
    public function index()
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }

    // 🟢 POST: নতুন appointment তৈরি করো
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'  => 'required|exists:patients,id',
            'doctor_name' => 'required|string|max:255',
            'date'        => 'required|date',
            'time'        => 'required',
            'status'      => 'nullable|string',
        ]);

        $appointment = Appointment::create($validated);
        return response()->json($appointment, 201);
    }

    // 🟢 GET: নির্দিষ্ট appointment দেখাও
    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return response()->json($appointment);
    }

    // 🟢 PUT/PATCH: appointment update করো
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validated = $request->validate([
            'doctor_name' => 'sometimes|string|max:255',
            'date'        => 'sometimes|date',
            'time'        => 'sometimes',
            'status'      => 'nullable|string',
        ]);

        $appointment->update($validated);
        return response()->json($appointment);
    }

    // 🟢 DELETE: appointment delete করো
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}
