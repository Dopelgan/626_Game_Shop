<?php

use App\Game;
use App\Genre;
use App\Platform;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','MainPageController@index')->name('main_page');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'AdminController@index')->name('admin');
Route::any('/game_page/{game_id}', function ($game_id) {

    $count = Game::find($game_id);
    $count->count++;
    $count->save();

    return view('game_page', [
        'game' => Game::where('id', $game_id)->first(),
        'genres' => Genre::whereIn('id', (DB::table('game_genre')->where('game_id', $game_id)->pluck('genre_id')))
    ]);

})->name('game_page');

Route::any('/platform/{platform_id}', function ($platform_id) {
    return view('platform', [
        'platform' => Platform::where('id', $platform_id)->get(),
        'games' => Game::where('platform_id', $platform_id)->get()
    ]);
});

Route::post('/game_add', 'AdminController@game_add')->name('game_add');
Route::post('/platform_add', 'AdminController@platform_add')->name('platform_add');

