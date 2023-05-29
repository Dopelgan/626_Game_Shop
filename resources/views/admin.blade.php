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

        <div class="card text-white bg-secondary d-flex flex-column w-25 m-2">

            <div class="card-header d-flex justify-content-center">{{ ('Добавить платформу в каталог') }}</div>

            <div class="mt-2">
                <label for="name">Название платформы</label>
                <br>
                <input class="form-control" id="name" type="text" name="name" required>
            </div>

            <div class="mt-2">
                <label for="small_image">Изображение для страницы игры</label>
                <br>
                <input type="file" class="form-control-file" id="small_image" name="small_image" required>
            </div>

            <div class="mt-2">
                <label for="big_image">Изображение для страницы игры</label>
                <br>
                <input type="file" class="form-control-file" id="big_image" name="big_image" required>
            </div>

            <button id="platform_add" class="btn btn-outline-success text-white mt-2">Добавить в каталог</button>

        </div>

    </div>

    <script>

        $(document).ready(function() {
            $('#game_add').on('click', function() {
                var fileInput = $('#image')[0]; // Получаем элемент input файла

                if (fileInput.files && fileInput.files[0]) {
                    var formData = new FormData(); // Создаем объект FormData

                    formData.append('image', fileInput.files[0]); // Добавляем изображение в FormData

                    $.ajax({
                        type: "POST", // METHOD
                        url: "{{ route('game_add') }}", // route
                        data: {
                            formData,
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            name: $('#name').val(),
                            quantity: $('#quantity').val(),
                            price: $('#price').val(),
                            year: $('#year').val(),
                            description: $('#description').val(),
                            image: $('#image').val(),
                        },
                        contentType: false,
                        processData: false,
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
                }
            });
        });

        $(document).ready(function() {
            $('#platform_add').on('click', function() {
                var fileInput1 = $('#small_image')[0]; // Получаем первый элемент input файла
                var fileInput2 = $('#big_image')[0]; // Получаем второй элемент input файла

                if (fileInput1.files && fileInput1.files[0] && fileInput2.files && fileInput2.files[0]) {
                    var formData = new FormData(); // Создаем объект FormData

                    formData.append('small_imag', fileInput1.files[0]); // Добавляем первое изображение в FormData
                    formData.append('big_imag', fileInput2.files[0]); // Добавляем второе изображение в FormData

                    $.ajax({
                        type: "POST", // METHOD
                        url: "{{ route('platform_add') }}", // route
                        data: {
                            formData,
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            name: $('#name').val(),
                            full_name: $('#full_name').val(),
                        },
                        contentType: false,
                        processData: false,
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
                }
            });
        });
    </script>
@endsection
