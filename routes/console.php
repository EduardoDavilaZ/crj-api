<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Shift;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $shift = Shift::findShiftById(3);
    if (!$shift) return;

    $nextShiftDate = Carbon::create(2026, 8, 14, 12, 0, 0);
    $now = Carbon::now();

    $daysDiff = $now->diffInDays($nextShiftDate, false);
    $cyclePosition = fmod($daysDiff, 14);

    if ($cyclePosition >= 0 && $cyclePosition <= 7) {
        $shift->is_active = true;
    } else {
        $shift->is_active = false;
    }

    $shift->save();
})->weeklyOn(5, '12:00');
