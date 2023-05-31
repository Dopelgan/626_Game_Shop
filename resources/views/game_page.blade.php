@extends('layouts.app')

@section('content')

    <div class="p-3 mb-2 text-white-50">
        <div class="d-flex justify-content-around container">
            <div class="d-flex justify-content-center w-75">
                @if(!$game->image==null)
                    <div>
                        <img
                            src='{{$game->image}}'
                            class="img-fluid mr-2"
                            width="240">
                        @endif
                        @if (!$game->quantity == 0)
                            <div class="mb-1"> В наличии: {{$game->quantity}} шт.</div>
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
                        <h5 class="text-white">{{$game->name}} {{$game->year}}г.</h5>
                        <h6>
                            @foreach($genres as $genre)
                                @if(!$genre == [])
                                    {{$genre->name}}
                                @endif
                            @endforeach
                        </h6>
                        <p>{{$game->description}}</p>
                    </div>
            </div>
        </div>
    </div>

    <script>
        $('#basket_add').on('click', function () {
            $.ajax({
                type: "POST", // METHOD
                url: "{{ route('basket_add') }}", // route
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    game_name: "{{$game->name}}",
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
                url: "{{route('favorite_add')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    game_name: "{{$game->name}}",
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
