<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Location;
use App\Models\Project;

class LocationController extends Controller
{
    public function getLocations(): JsonResponse
    {
        $locations = Location::getAllLocations();

        if ($locations->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron ubicaciones registradas.'
            ], 404);
        }

        return response()->json($locations, 200);
    }

    public function getLocationsByProject(int $id): JsonResponse
    {

        $project = Project::findProject($id);

        if (!$project) {
            return response()->json([
                'message' => 'El proyecto especificado no existe.'
            ], 404);
        }

        $locations = Location::getLocationsByProjectId($id);

        if ($locations->isEmpty()) {
            return response()->json([
                'message' => 'No hay ubicaciones asociadas a este proyecto.'
            ], 404);
        }

        return response()->json($locations, 200);
    }

    public function getLocationsById(int $id): JsonResponse
    {
        $location = Location::getLocationById($id);

        if (!$location) {
            return response()->json([
                'message' => 'Ubicación no encontrada.'
            ], 404);
        }

        return response()->json($location, 200);
    }
}
