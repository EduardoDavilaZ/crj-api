<?php

namespace App\Http\Controllers;

use App\Models\Craft;
use App\Models\AgeRange;
use Illuminate\Http\Request;

class CraftController extends Controller
{
    /**
     * Obtener todos los rangos de edad.
     */
    public function getAgeRanges()
    {
        $ageRanges = AgeRange::orderBy('min_age')->get();

        return response()->json($ageRanges);
    }

    /**
     * Obtener una manualidad filtrada por rango de edad.
     */
    public function getCraft(Request $request)
    {
        $request->validate([
            'age_range_id' => 'required|integer|exists:age_ranges,id',
        ]);

        $crafts = Craft::query()
            ->where('is_active', true)
            ->with([
                'ageRanges',
                'materials'
            ])
            ->whereHas('ageRanges', function ($q) use ($request) {
                $q->where('age_ranges.id', $request->age_range_id);
            })
            ->inRandomOrder()
            ->get();

        return response()->json([
            'data' => $crafts,
            'total' => $crafts->count(),
        ]);
    }
}
