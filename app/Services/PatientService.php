<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PatientService
{
    public function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make('defaultpassword123'), // 👈 generate hashed dummy password
            'id_type' => $data['id_type'],
            'id_no' => $data['id_no'],
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'address' => $data['address'],
        ]);

        return Patient::create([
            'user_id' => $user->id,
            'medium_acquisition' => $data['medium_acquisition'],
        ]);
    }

    public function update($id, array $data)
    {
        $patient = Patient::with('user')->findOrFail($id);
        $patient->user->update($data);
        $patient->update(['medium_acquisition' => $data['medium_acquisition']]);
        return $patient;
    }

    public function delete($id)
    {
        return Patient::destroy($id);
    }

    public function list()
    {
        return Patient::with('user')->get();
    }

    public function detail($id)
    {
        return Patient::with('user')->find($id);
    }
}
