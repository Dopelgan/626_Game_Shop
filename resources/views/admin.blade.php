@extends('layouts.app')

@section('content')
    <h4 class="d-flex justify-content-center text-white">Страница администратора</h4>
    <div class="d-flex justify-content-center text-white-50 w-75 container">


        <div class="card text-white bg-secondary d-flex flex-column w-25 m-2">

            <div class="card-header d-flex justify-content-center">{{ ('Добавить игру в каталог') }}</div>

            <div class="mt-2">
                <label for="name">Название игры</label>
                <br>
                <input class="form-control" id="name" type="text" name="name" required>
            </div>

            <div class="mt-2">
                <label for="platform_id">ID платформы</label>
                <br>
                <input class="form-control" id="platform_id" type="text" name="platform_id" required>
            </div>

            <div class="mt-2">
                <label for="quantity">Количество</label>
                <input class="form-control" type="text" id="quantity" name="quantity">
            </div>

            <div class="mt-2">
                <label for="price">Цена</label>
                <br>
                <input class="form-control" type="text" id="price" name="price">
            </div>

            <div class="mt-2">
                <label for="year">Год выхода</label>
                <br>
                <input class="form-control" type="text" id="year" name="year" required>
            </div>

            <div class="mt-2">
                <label for="description">Описание</label>
                <br>
                <textarea class="form-control" id="description" name="description" cols="30" rows="5"
                          maxlength="1000">Описание пока не добавили.</textarea>
            </div>

            <div class="mt-2">
                <label for="image">Ссылка на изображение</label>
                <br>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>

            <button id="game_add" class="btn btn-outline-success text-white mt-2">Добавить в каталог</button>

        </div>

    </div>

    <script>
        $('#game_add').on('click', function () {
            $.ajax({
                type: "POST", // METHOD
                url: "{{ route('game_add') }}", // route
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: $('#name').val(),
                    quantity: $('#quantity').val(),
                    price: $('#price').val(),
                    year: $('#year').val(),
                    description: $('#description').val(),
                    image: $('#image').val(),
                },
                success: function (response) {
                    console.log(response.result)
                },
                error: function (response) {
                    $.each(response.responseJSON.errors, function (name, messages) {
                        console.log(name)
                        $.each(messages, function (message) {
                            console.log(message)
                        })
                    })
                }
            });
        })
    </script>
@endsection
