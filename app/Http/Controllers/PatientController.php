<?php

namespace App\Http\Controllers;

use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected $service;

    public function __construct(PatientService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'id_type' => 'required',
                'id_no' => 'required',
                'gender' => 'required|in:male,female,other',
                'dob' => 'required|date',
                'address' => 'required',
                'medium_acquisition' => 'required',
            ]);
    
            return response()->json($this->service->create($validated), 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error creating patient: ' . $th->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'id_type' => 'required',
                'id_no' => 'required',
                'gender' => 'required|in:male,female,other',
                'dob' => 'required|date',
                'address' => 'required',
                'medium_acquisition' => 'required',
            ]);

            $patient = $this->service->detail($id);

            if (!$patient) {
                return response()->json(['message' => 'Patient not found'], 404);
            }

            $updated = $this->service->update($id, $validated);
            return response()->json($updated);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error updating patient: ' . $th->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $patient = $this->service->detail($id);

            if (!$patient) {
                return response()->json(['message' => 'Patient not found'], 404);
            }
            
            $this->service->delete($id);
            return response()->json(['message' => 'Deleted']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error deleting patient: ' . $th->getMessage()], 500);
        }
    }

    public function index()
    {
        try {
            return response()->json($this->service->list());
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error fetching patients: ' . $th->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $patient = $this->service->detail($id);

            if (!$patient) {
                return response()->json(['message' => 'Patient not found'], 404);
            }

            return response()->json($patient);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error fetching patient: ' . $th->getMessage()], 500);
        }
    }
}
