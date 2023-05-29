<?php

namespace App\Http\Controllers;

use App\Game;
use App\Platform;
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

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = time() . '.' . $image->extension();

            $image->move(public_path('games_images'), $imageName);
        }

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
        if ($request->hasFile('small_image') && $request->hasFile('big_image')) {
            $small_image = $request->file('small_image');
            $big_image = $request->file('big_image');

            $small_imageName = time() . '.' . $small_image->extension();
            $big_imageName = time() . '.' . $big_image->extension();

            $small_image->move(public_path('platforms_images/small'), $small_imageName);
            $big_image->move(public_path('platforms_images/big'), $big_imageName);
        }

        DB::transaction(function () use ($request) {
            $game = new Platform();
            $game->name = $request->name;
            $game->full_name = $request->full_name;
            $game->save();
        });
    }
}
