<?php

namespace App\Services;

use App\Models\Billing;

class BillingService
{
    public function getAllBillings()
    {
        return Billing::all();
    }

    public function createBilling(array $data)
    {
        return Billing::create($data);
    }

    public function getBillingById($id)
    {
        return Billing::findOrFail($id);
    }

    public function updateBilling($id, array $data)
    {
        $billing = Billing::findOrFail($id);
        $billing->update($data);
        return $billing;
    }

    public function deleteBilling($id)
    {
        $billing = Billing::findOrFail($id);
        return $billing->delete();
    }
}
