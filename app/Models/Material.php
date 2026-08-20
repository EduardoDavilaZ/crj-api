<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'name',
    ];

    public function activities()
    {
        return $this->belongsToMany(
            Activity::class,
            'activity_material'
        )->withTimestamps();
    }

    public function crafts()
    {
        return $this->belongsToMany(
            Craft::class,
            'craft_material',
            'material_id',
            'craft_id'
        )->withTimestamps();
    }
}
