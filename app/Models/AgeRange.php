<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgeRange extends Model
{
    protected $fillable = [
        'name',
        'min_age',
        'max_age',
    ];

    public function activities()
    {
        return $this->belongsToMany(
            Activity::class,
            'activity_age_range'
        )->withTimestamps();
    }

    public function crafts()
    {
        return $this->belongsToMany(
            Craft::class,
            'craft_age_range',
            'age_range_id',
            'craft_id'
        )->withTimestamps();
    }
}
