<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Craft extends Model
{
    protected $fillable = [
        'name',
        'description',
        'instructions',
        'image_url',
        'source_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Rangos de edad de la manualidad.
     */
    public function ageRanges(): BelongsToMany
    {
        return $this->belongsToMany(
            AgeRange::class,
            'craft_age_range',
            'craft_id',
            'age_range_id'
        )->withTimestamps();
    }

    /**
     * Materiales necesarios para la manualidad.
     */
    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(
            Material::class,
            'craft_material',
            'craft_id',
            'material_id'
        )->withTimestamps();
    }
}
