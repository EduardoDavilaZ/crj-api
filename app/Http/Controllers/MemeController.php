<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meme;
use Illuminate\Http\Request;

class MemeController extends Controller
{
    public function index(Request $request)
    {
        $memes = Meme::getPaginatedMemes(10);
        return response()->json($memes);
    }
}
