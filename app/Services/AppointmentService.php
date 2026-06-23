<?php

namespace App\Services;

use App\Models\Appointment;

class AppointmentService
{
    // সব appointments list
    public function getAllAppointments()
    {
        return Appointment::all();
    }

    // নতুন appointment তৈরি
    public function createAppointment(array $data)
    {
        return Appointment::create($data);
    }

    // নির্দিষ্ট appointment দেখাও
    public function getAppointmentById($id)
    {
        return Appointment::findOrFail($id);
    }

    // appointment update করো
    public function updateAppointment($id, array $data)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($data);
        return $appointment;
    }

    // appointment delete করো
    public function deleteAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        return $appointment->delete();
    }
}

