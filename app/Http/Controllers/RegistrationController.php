<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'needs_vest' => 'boolean',
            'selectedShifts' => 'required|array',
            'selectedShifts.*.shift_id' => 'required|exists:shifts,id',
            'selectedShifts.*.date' => 'required|date', // Validamos que venga la fecha
        ]);

        $registration = Registration::create([
            'name' => $validated['name'],
            'needs_vest' => $validated['needs_vest'] ?? false,
        ]);

        // Preparamos los datos estructurados para la tabla pivote incluyendo la fecha y los timestamps
        $shiftsData = [];
        foreach ($validated['selectedShifts'] as $shift) {
            $shiftsData[$shift['shift_id']] = [
                'date' => $shift['date'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Asociamos los turnos con sus respectivas fechas
        $registration->shifts()->attach($shiftsData);

        return response()->json([
            'message' => '¡Inscripción registrada con éxito!',
            'data' => $registration->load('shifts')
        ], 201);
    }
}
