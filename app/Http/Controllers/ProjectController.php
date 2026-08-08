<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function getProjectsWithShifts(): JsonResponse
    {
        $projects = Project::getProjectsWithShifts();

        $formattedProjects = $projects->map(function ($project) {

            $uniqueDays = [];

            $filteredShifts = $project->shifts->where('is_active', true)->filter(function ($shift) use (&$uniqueDays) {
                if ($shift->date) {
                    $shiftDate = Carbon::parse($shift->date);
                    $dayKey = $shiftDate->toDateString();

                    if (!isset($uniqueDays[$dayKey]) && count($uniqueDays) < 3) {
                        $uniqueDays[$dayKey] = true;
                        $shift->formatted_day = ucfirst($shiftDate->locale('es')->isoFormat('dddd, D MMMM'));
                        return true;
                    }
                } else {
                    $dayNameLower = strtolower($shift->day);

                    $daysMap = [
                        'lunes' => Carbon::MONDAY,
                        'martes' => Carbon::TUESDAY,
                        'miércoles' => Carbon::WEDNESDAY,
                        'jueves' => Carbon::THURSDAY,
                        'viernes' => Carbon::FRIDAY,
                        'sábado' => Carbon::SATURDAY,
                        'domingo' => Carbon::SUNDAY,
                    ];

                    if (isset($daysMap[$dayNameLower]) && !isset($uniqueDays[$dayNameLower]) && count($uniqueDays) < 3) {
                        $uniqueDays[$dayNameLower] = true;

                        $englishDays = [
                            'lunes' => 'Monday',
                            'martes' => 'Tuesday',
                            'miércoles' => 'Wednesday',
                            'jueves' => 'Thursday',
                            'viernes' => 'Friday',
                            'sábado' => 'Saturday',
                            'domingo' => 'Sunday'
                        ];

                        $englishDay = $englishDays[$dayNameLower] ?? 'Monday';
                        $nextDate = new Carbon('next ' . $englishDay, 'Europe/Madrid');

                        $shift->formatted_day = ucfirst($nextDate->locale('es')->isoFormat('dddd, D MMMM'));

                        return true;
                    }
                }
                return false;
            })->take(3)->map(function ($shift) {
                return [
                    'day' => $shift->formatted_day ?? $shift->day,
                    'time' => substr($shift->start_time, 0, 5) . ' - ' . substr($shift->end_time, 0, 5)
                ];
            })->values();

            return [
                'id' => $project->id,
                'slug' => $project->slug,
                'title' => $project->title,
                'description' => $project->description,
                'is_active' => $project->is_active,
                'shifts' => $filteredShifts
            ];
        });

        return response()->json($formattedProjects);
    }

    public function getShiftsByProject(int $projectId): JsonResponse
    {
        $project = Project::find($projectId);

        $now = Carbon::now('Europe/Madrid');
        $currentDayOfWeek = $now->dayOfWeek; // 0 (Domingo) a 6 (Sábado)
        $currentHour = $now->hour;

        $isNextWeek = ($currentDayOfWeek === Carbon::FRIDAY && $currentHour >= 12) ||
                      $currentDayOfWeek === Carbon::SATURDAY ||
                      $currentDayOfWeek === Carbon::SUNDAY;

        $distanceToMonday = $currentDayOfWeek === 0 ? -6 : 1 - $currentDayOfWeek;
        $monday = $now->copy()->addDays($distanceToMonday)->startOfDay();

        if ($isNextWeek) {
            $monday->addDays(7);
        }

        if ($project && $project->project_type === 'occasional') {
            $endDate = $monday->copy()->addDays(6)->endOfDay(); // Domingo para ocasionales
        } else {
            $endDate = $monday->copy()->addDays(4)->endOfDay(); // Viernes para ordinarios
        }

        $locations = Location::whereHas('shifts', function($query) use ($projectId) {
            $query->where('project_id', $projectId)
                ->where('is_active', true);
        })->with([
            'shifts' => function($query) use ($projectId, $monday, $endDate) {
                $query->where('project_id', $projectId)
                    ->where('is_active', true)
                    ->with([
                        'registrations' => function($regQuery) use ($monday, $endDate) {
                            $regQuery->whereBetween('registration_shift.date', [
                                $monday->toDateString(),
                                $endDate->toDateString()
                            ]);
                        }
                    ]);
            }
        ])->get();

        return response()->json($locations);
    }
}
