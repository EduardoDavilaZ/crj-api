<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name',
        'description',
        'instructions',
        'activity_type_id',
        'participants_min',
        'participants_max',
        'image_url',
        'source_url',
        'is_active',
    ];

    public function activityType()
    {
        return $this->belongsTo(ActivityType::class);
    }

    public function ageRanges()
    {
        return $this->belongsToMany(
            AgeRange::class,
            'activity_age_range'
        )->withTimestamps();
    }

    public function materials()
    {
        return $this->belongsToMany(
            Material::class,
            'activity_material'
        )->withTimestamps();
    }
}
