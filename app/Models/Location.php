<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

class Location extends Model
{
    protected $fillable = ['name', 'description', 'img_path', 'location'];

    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class);
    }

    public static function getAllLocations(): Collection
    {
        return self::all();
    }

    public static function getLocationsByProjectId(int $projectId): Collection
    {
        // Buscamos las ubicaciones que tienen turnos en este proyecto evitando duplicados
        return self::whereHas('shifts', function ($query) use ($projectId) {
            $query->where('project_id', $projectId);
        })->get();
    }

    public static function getLocationById(int $id): ?self
    {
        return self::find($id);
    }
}
