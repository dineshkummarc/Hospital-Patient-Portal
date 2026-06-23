<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Billing;

class BillingController extends Controller
{
    public function index()
    {
        $billings = Billing::all();
        return response()->json($billings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'amount'     => 'required|numeric|min:0',
            'status'     => 'nullable|string|in:unpaid,paid',
        ]);

        $billing = Billing::create($validated);
        return response()->json($billing, 201);
    }

    public function show($id)
    {
        $billing = Billing::findOrFail($id);
        return response()->json($billing);
    }

    public function update(Request $request, $id)
    {
        $billing = Billing::findOrFail($id);

        $validated = $request->validate([
            'amount' => 'sometimes|numeric|min:0',
            'status' => 'nullable|string|in:unpaid,paid',
        ]);

        $billing->update($validated);
        return response()->json($billing);
    }

    public function destroy($id)
    {
        $billing = Billing::findOrFail($id);
        $billing->delete();

        return response()->json(['message' => 'Billing deleted successfully']);
    }
}
