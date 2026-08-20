<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
class Meme extends Model
{
    protected $fillable = ['image_path'];

    public static function getPaginatedMemes(int $perPage = 10)
    {
        $memes = self::orderBy('created_at', 'desc')->paginate($perPage);

        $memes->getCollection()->transform(function ($meme) {
            $meme->image_url = asset('storage/memes/' . $meme->image_path);
            return $meme;
        });

        return $memes;
    }
}
