<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Registration extends Model
{
    protected $fillable = ['name', 'needs_vest'];

    public function shifts(): BelongsToMany
    {
        return $this->belongsToMany(Shift::class, 'registration_shift');
    }
}
