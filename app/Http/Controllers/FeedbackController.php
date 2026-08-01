<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class FeedbackController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:50',
            'comment' => 'required|string|max:1000',
        ]);

        do {
            $code = strtoupper(Str::random(4));
        } while (Feedback::where('code', $code)->exists());

        $feedback = Feedback::create([
            'name' => $validated['name'] ?: 'Anónimo',
            'comment' => $validated['comment'],
            'code' => $code,
        ]);

        return response()->json([
            'message' => 'Comentario enviado con éxito',
            'code' => $code
        ], 201);
    }

    public function show(string $code): JsonResponse
    {
        $feedback = Feedback::where('code', strtoupper($code))->first();

        if (!$feedback) {
            return response()->json(['message' => 'Código no encontrado'], 404);
        }

        return response()->json([
            'name' => $feedback->name,
            'comment' => $feedback->comment,
            'response' => $feedback->response,
            'created_at' => $feedback->created_at,
        ]);
    }
}
