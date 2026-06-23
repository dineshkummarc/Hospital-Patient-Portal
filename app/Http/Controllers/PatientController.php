<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PatientService;

class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function index()
    {
        $patients = $this->patientService->getAllPatients();
        return response()->json($patients);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:patients,email',
            'age'    => 'required|integer',
            'gender' => 'required|string',
            'address'=> 'required|string|max:255',
            'phone'  => 'nullable|string|max:20',
        ]);

        $patient = $this->patientService->createPatient($validated);
        return response()->json($patient, 201);
    }

    public function show($id)
    {
        $patient = $this->patientService->getPatientById($id);
        return response()->json($patient);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:patients,email,' . $id,
            'phone' => 'nullable|string|max:20',
        ]);

        $patient = $this->patientService->updatePatient($id, $validated);
        return response()->json($patient);
    }

    public function destroy($id)
    {
        $this->patientService->deletePatient($id);
        return response()->json(['message' => 'Patient deleted successfully']);
    }
}
