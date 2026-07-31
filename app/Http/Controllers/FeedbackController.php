<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Str;

class FeedbackController extends Controller
{
    // 1. Crear un comentario anónimo y generar código único de 4 caracteres
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:50',
            'comment' => 'required|string|max:1000',
        ]);

        // Generar un código único alfanumérico en mayúsculas de 4 caracteres
        do {
            $code = strtoupper(Str::random(4));
        } while (Feedback::where('code', $code)->exists());

        $feedback = Feedback::create([
            'name' => $validated['name'] ?: 'Anónimo',
            'comment' => $validated['comment'],
            'code' => $code,
        ]);

        return response()->json([
            'message' => 'Feedback enviado con éxito',
            'code' => $code // Se devuelve al frontend para que el usuario lo guarde
        ], 201);
    }

    // 2. Consultar el estado y respuesta del comentario mediante el código
    public function show($code)
    {
        $feedback = Feedback::where('code', strtoupper($code))->first();

        if (!$feedback) {
            return response()->json(['message' => 'Código no encontrado'], 404);
        }

        return response()->json([
            'name' => $feedback->name,
            'comment' => $feedback->comment,
            'response' => $feedback->response, // Si el admin no ha respondido, vendrá null
            'created_at' => $feedback->created_at,
        ]);
    }
}
