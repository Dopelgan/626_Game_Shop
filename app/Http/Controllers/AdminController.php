<?php

namespace App\Http\Controllers;

use App\Game;
use App\Genre;
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
            'name.unique' => 'Такая игра уже в каталоге.',
            'name.max:255' => 'Наименование игры не должно превышать 255 символов.',
            'quantity.numeric' => 'В поле "Количество" вводимое значение должно быть числовым',
            'quantity.max:4294967295' => 'Количество не должно превышать "4294967295"',
            'image.mimes:png,jpg,jpeg' => 'Неподдерживаемый формат изображения',
            'image.max:2048' => 'Слишком высокое разрешение изображения'
        ];

        $request->validate([
            'name' => 'max:255|required|unique:games,name',
            'quantity' => 'numeric|max:4294967295',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ], $messages);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = time() . '.' . $image->extension();

            $image->move(public_path('images/games_images'), $imageName);

            $game = new Game();
            $game->name = $request->name;
            $game->platform_id = $request->platform_id;
            $game->quantity = $request->quantity;
            $game->price = $request->price;
            $game->year = $request->year;
            $game->description = $request->description;
            $game->image = (public_path('images/games_images').'/'.$imageName);
            $game->save();

        return response()->json(['message' => 'Игра успешно добавлена в каталог']);

        }
    }

    public function platform_add(Request $request)
    {
        Log::debug('test', $request->all());

        if ($request->hasFile('icon') && $request->hasFile('image')) {

            $icon = $request->file('icon');
            $image = $request->file('image');

            $iconName = time() . '.' . $icon->extension();
            $imageName = time() . '.' . $image->extension();

            $icon->move(public_path('images/platforms_images/icon'), $iconName);
            $image->move(public_path('images/platforms_images/image'), $imageName);


            DB::transaction(function () use ($request, $iconName, $imageName) {
                $platform = new Platform();
                $platform->name = $request->name;
                $platform->full_name = $request->full_name;
                $platform->icon = public_path('images/platforms_images/icon') . '/' . $iconName;
                $platform->image = public_path('images/platforms_images/image') . '/' . $imageName;
                $platform->save();
            });

            return response()->json(['message' => 'Платформа успешно добавлена']);
        }

        return response()->json(['message' => 'Всё пошло по пизде']);
    }
}
