<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\AgeRange;
use Illuminate\Http\Request;

class ActivityController extends Controller
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
     * Obtener todos los tipos de actividad.
     */
    public function getActivityTypes()
    {
        $activityTypes = ActivityType::orderBy('id')->get();

        return response()->json($activityTypes);
    }

    /**
     * Obtener actividades filtradas por rango de edad y tipo.
     */
    public function getActivity(Request $request)
    {
        $request->validate([
            'age_range_id' => 'nullable|integer|exists:age_ranges,id',
            'activity_type_id' => 'nullable|integer|exists:activity_types,id',
        ]);

        $query = Activity::query()
            ->where('is_active', true)
            ->with([
                'activityType',
                'ageRanges',
                'materials'
            ]);

        /*
         * Filtrar por rango de edad.
         */
        if ($request->filled('age_range_id')) {
            $query->whereHas('ageRanges', function ($q) use ($request) {
                $q->where('age_ranges.id', $request->age_range_id);
            });
        }

        /*
         * Filtrar por tipo de actividad.
         */
        if ($request->filled('activity_type_id')) {
            $query->where(
                'activity_type_id',
                $request->activity_type_id
            );
        }

        $activities = $query
            ->inRandomOrder()
            ->get();

        return response()->json([
            'data' => $activities,
            'total' => $activities->count(),
        ]);
    }
}
