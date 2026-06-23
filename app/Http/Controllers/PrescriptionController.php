<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;

class PrescriptionController extends Controller
{
    // 🟢 GET: সব prescriptions list দেখাও
    public function index()
    {
        $prescriptions = Prescription::all();
        return response()->json($prescriptions);
    }

    // 🟢 POST: নতুন prescription তৈরি করো (ফাইল upload সহ)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'  => 'required|exists:patients,id',
            'doctor_name' => 'required|string|max:255',
            'file'        => 'required|file|mimes:pdf,jpg,png',
        ]);

        // ফাইল upload করে path save করো
        $path = $request->file('file')->store('prescriptions', 'public');

        $prescription = Prescription::create([
            'patient_id'  => $validated['patient_id'],
            'doctor_name' => $validated['doctor_name'],
            'file_path'   => $path,
        ]);

        return response()->json($prescription, 201);
    }

    // 🟢 GET: নির্দিষ্ট prescription দেখাও
    public function show($id)
    {
        $prescription = Prescription::findOrFail($id);
        return response()->json($prescription);
    }

    // 🟢 PUT/PATCH: prescription update করো
    public function update(Request $request, $id)
    {
        $prescription = Prescription::findOrFail($id);

        $validated = $request->validate([
            'doctor_name' => 'sometimes|string|max:255',
            'file'        => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('prescriptions', 'public');
            $validated['file_path'] = $path;
        }

        $prescription->update($validated);
        return response()->json($prescription);
    }

    // 🟢 DELETE: prescription delete করো
    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();

        return response()->json(['message' => 'Prescription deleted successfully']);
    }
}
