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
            'selectedShifts' => 'required|array', // Array con los IDs de los turnos
            'selectedShifts.*' => 'exists:shifts,id'
        ]);

        // Crear la inscripción del usuario
        $registration = Registration::create([
            'name' => $validated['name'],
            'needs_vest' => $validated['needs_vest'] ?? false,
        ]);

        // Vincular los turnos mediante la tabla pivote
        $registration->shifts()->attach($validated['selectedShifts']);

        return response()->json([
            'message' => '¡Inscripción registrada con éxito!',
            'data' => $registration->load('shifts')
        ], 201);
    }
}
