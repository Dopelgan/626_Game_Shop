@extends('layouts.app')

@section('content')

    <div class="p-3 mb-2 text-white-50">
        <div class="d-flex justify-content-around container">
            <div class="d-flex justify-content-center w-75">
                @if(!$need_game->image==null)
                    <div>
                        <img
                            src='{{$need_game->image}}'
                            class="img-fluid mr-2"
                            width="240">
                        @endif
                        @if (!$need_game->quantity == 0)
                            <div class="mb-1"> В наличии: {{$need_game->quantity}} шт.</div>
                            <button id="basket_add" class="btn btn-outline-warning text-white">Добавить в
                                корзину
                            </button>
                        @else
                            <div class="mb-1">Нет в наличии.</div>
                        @endif
                        <button id="favorite_add" class="btn btn-outline-success text-white" type="submit">Добавить в
                            избранное
                        </button>
                    </div>

                    <div class="w-50">
                        <h5 class="text-white">{{$need_game->name}} {{$need_game->year}}г.</h5>
                        <h6>
                            @foreach($need_genres as $genre)
                                @if(!$genre == [])
                                    {{$genre}}
                                @endif
                            @endforeach
                        </h6>
                        <p>{{$need_game->description}}</p>
                    </div>
            </div>
        </div>
    </div>

    <script>
        $('#basket_add').on('click', function () {
            $.ajax({
                type: "POST", // METHOD
                url: "{{ route('add_game_to_basket') }}", // route
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    game_name: "{{$need_game->name}}",
                    user_name: "Admin"
                },
                success: function (response) {
                    console.log(response.result)
                },
                error: function (response) {
                    alert(response.message)
                }
            });
        })
        $('#favorite_add').on('click', function () {
            $.ajax({
                type: "POST",
                url: "{{route('add_favorite')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    game_name: "{{$need_game->name}}",
                    user_name: "Admin"
                },
                success: function (response) {
                    console.log(response.result)
                },
                error: function (response) {
                    alert(response.message)
                }
            })
        })
    </script>

@endsection
