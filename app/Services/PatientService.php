<?php

namespace App\Services;

use App\Models\Patient;

class PatientService
{
    // 🟢 সব patients list
    public function getAllPatients()
    {
        return Patient::all();
    }

    // 🟢 নতুন patient তৈরি
    public function createPatient(array $data)
    {
        return Patient::create($data);
    }

    // 🟢 নির্দিষ্ট patient দেখাও
    public function getPatientById($id)
    {
        return Patient::findOrFail($id);
    }

    // 🟢 patient update করো
    public function updatePatient($id, array $data)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($data);
        return $patient;
    }

    // 🟢 patient delete করো
    public function deletePatient($id)
    {
        $patient = Patient::findOrFail($id);
        return $patient->delete();
    }
}
