<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shift extends Model
{
    protected $fillable = ['project_id', 'location_id', 'max_volunteers', 'day', 'date', 'start_time', 'end_time'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function registrations(): BelongsToMany
    {
        return $this->belongsToMany(Registration::class, 'registration_shift');
    }
}
