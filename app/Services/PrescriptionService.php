<?php

namespace App\Services;

use App\Models\Prescription;

class PrescriptionService
{
    // 🟢 সব prescriptions list
    public function getAllPrescriptions()
    {
        return Prescription::all();
    }

    // 🟢 নতুন prescription তৈরি
    public function createPrescription(array $data)
    {
        return Prescription::create($data);
    }

    // 🟢 নির্দিষ্ট prescription দেখাও
    public function getPrescriptionById($id)
    {
        return Prescription::findOrFail($id);
    }

    // 🟢 prescription update করো
    public function updatePrescription($id, array $data)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->update($data);
        return $prescription;
    }

    // 🟢 prescription delete করো
    public function deletePrescription($id)
    {
        $prescription = Prescription::findOrFail($id);
        return $prescription->delete();
    }
}

