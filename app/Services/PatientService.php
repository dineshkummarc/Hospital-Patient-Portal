<?php

namespace App\Services;

use App\Models\Patient;

class PatientService
{
    public function getAllPatients()
    {
        return Patient::all();
    }

    public function createPatient(array $data)
    {
        return Patient::create($data);
    }

    public function getPatientById($id)
    {
        return Patient::findOrFail($id);
    }

    public function updatePatient($id, array $data)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($data);
        return $patient;
    }

    public function deletePatient($id)
    {
        $patient = Patient::findOrFail($id);
        return $patient->delete();
    }
}
