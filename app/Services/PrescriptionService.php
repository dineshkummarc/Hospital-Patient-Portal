<?php

namespace App\Services;

use App\Models\Prescription;

class PrescriptionService
{
    public function getAllPrescriptions()
    {
        return Prescription::all();
    }

    public function createPrescription(array $data)
    {
        return Prescription::create($data);
    }

    public function getPrescriptionById($id)
    {
        return Prescription::findOrFail($id);
    }

    public function updatePrescription($id, array $data)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->update($data);
        return $prescription;
    }

    public function deletePrescription($id)
    {
        $prescription = Prescription::findOrFail($id);
        return $prescription->delete();
    }
}

