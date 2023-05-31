<?php

namespace App\Http\Controllers;

use App\Game;
use App\Genre;
use App\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainPageController extends Controller
{
    public function index()
    {
        return view('main', [
            'games' => Game::get(),
            'genres' => Genre::get(),
            'platforms' => Platform::get()
        ]);
    }
}
