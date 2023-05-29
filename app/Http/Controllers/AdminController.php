<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }

    public function game_add(Request $request)
    {
        Log::debug('', $request->all());

        $messages = [
            'game_name.unique' => 'Такая игра уже в каталоге.',
            'game_name.max:255' => 'Наименование игры не должно превышать 255 символов.',
            'quantity.numeric' => 'В поле "Количество" вводимое значение должно быть числовым',
            'quantity.max:10' => 'Количество не должно превышать "4294967295"',
            'image.mimes:png,jpg,jpeg' => 'Неподдерживаемый формат изображения',
            'image.max:2048' => 'Слишком высокое разрешение изображения'
        ];

        $request->validate([
            'game_name' => 'max:255|required|unique:games,name',
            'quantity' => 'numeric|max:10',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ], $messages);

        $imageName = time().'.'.$request->image->extension();

        $request->image->move(public_path('games_images'), $imageName);

        DB::transaction(function () use ($request) {
            $game = new Game();
            $game->name = $request->name;
            $game->platform_id = $request->platform_id;
            $game->quantity = $request->quantity;
            $game->price = $request->price;
            $game->year = $request->year;
            $game->description = $request->description;
            $game->save();
        });

    }

    public function platform_add(Request $request)
    {
        dd($request->all());
    }
}
