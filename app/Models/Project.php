<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = ['slug', 'title', 'description'];

    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class);
    }
    public static function getProjectsWithShifts(): Collection
    {
        return self::with('shifts')->get();
    }

    // public function announcements(): HasMany
    // {
    //     return $this->hasMany(Announcement::class);
    // }

    public static function findProject(int $id): Self
    {
        return Project::find($id);
    }
}
