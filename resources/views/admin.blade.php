@extends('layouts.app')

@section('content')

    <div id="error" class="alert alert-danger" role="alert"></div>
    <div id="success" class="alert alert-success" role="alert"></div>

    <h4 class="d-flex justify-content-center text-white">Страница администратора</h4>
    <div class="d-flex justify-content-center text-white-50 w-75 container">

        <div class="card text-white bg-secondary d-flex flex-column w-25 m-2">

            <div class="card-header d-flex justify-content-center">{{ ('Добавить игру в каталог') }}</div>

            <div class="mt-2">
                <label for="game-name">Название игры</label>
                <br>
                <input class="form-control" id="game-name" type="text" name="game-name" required>
            </div>

            <div class="mt-2">
                <label for="platform-id">ID платформы</label>
                <br>
                <input class="form-control" id="platform-id" type="number" name="platform-id" required>
            </div>

            <div class="mt-2">
                <label for="game-quantity">Количество</label>
                <input class="form-control" type="number" id="game-quantity" name="game-quantity">
            </div>

            <div class="mt-2">
                <label for="game-price">Цена</label>
                <br>
                <input class="form-control" type="number" id="game-price" name="game-price">
            </div>

            <div class="mt-2">
                <label for="game-year">Год выхода</label>
                <br>
                <input class="form-control" type="number" id="game-year" name="game-year" required>
            </div>

            <div class="mt-2">
                <label for="game-description">Описание</label>
                <br>
                <textarea class="form-control" id="game-description" name="game-description" cols="30" rows="5"
                          maxlength="1000">Описание пока не добавили.</textarea>
            </div>

            <div class="mt-2">
                <label for="game-image">Ссылка на изображение</label>
                <br>
                <input type="file" class="form-control-file" id="game-image" name="game-image" required>
            </div>

            <button id="game-add" class="btn btn-outline-success text-white mt-2">Добавить в каталог</button>

        </div>

        <div class="card text-white bg-secondary d-flex flex-column w-25 m-2">

            <div class="card-header d-flex justify-content-center">{{ ('Добавить платформу в каталог') }}</div>

            <div class="mt-2">
                <label for="platform-name">Сокращенное название платформы</label>
                <br>
                <input class="form-control" id="platform-name" type="text" name="platform-name" required>
            </div>

            <div class="mt-2">
                <label for="platform-full-name">Полное название платформы</label>
                <br>
                <input class="form-control" id="platform-full-name" type="text" name="platform-full-name" required>
            </div>

            <div class="mt-2">
                <label for="platform-icon">Изображение для страницы игры</label>
                <br>
                <input type="file" class="form-control-file" id="platform-icon" name="platform-icon" required>
            </div>

            <div class="mt-2">
                <label for="platform-image">Изображение для главной страницы</label>
                <br>
                <input type="file" class="form-control-file" id="platform-image" name="platform-image" required>
            </div>

            <button id="platform-add" class="btn btn-outline-success text-white mt-2">Добавить в каталог</button>

        </div>

    </div>

    <script>

        $(document).ready(function () {
            $('#game-add').on('click', function () {
                var fileInput = $('#game-image')[0]; // Получаем элемент input файла

                if (fileInput.files && fileInput.files[0]) {
                    var formData = new FormData(); // Создаем объект FormData

                    formData.append('image', fileInput.files[0]); // Добавляем изображение игры в FormData
                    formData.append('name', $('#game-name').val()); // Добавляем название игры в FormData
                    formData.append('quantity', $('#game-quantity').val()); // Добавляем количество игр в FormData
                    formData.append('price', $('#game-price').val()); // Добавляем цену игры в FormData
                    formData.append('platform_id', $('#platform-id').val()); // Добавляем платформу игры в FormData
                    formData.append('year', $('#game-year').val()); // Добавляем год выхода игры в FormData
                    formData.append('description', $('#game-description').val()); // Добавляем описание игры в FormData

                    $.ajax({
                        type: "POST", // METHOD
                        url: "{{ route('game_add') }}", // route
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            $('#success').html(response.message)
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

        $(document).ready(function () {
            $('#platform-add').on('click', function () {

                var fileInput1 = $('#platform-icon')[0]; // Получаем первый элемент input файла
                var fileInput2 = $('#platform-image')[0]; // Получаем второй элемент input файла

                if (fileInput1.files && fileInput1.files[0] && fileInput2.files && fileInput2.files[0]) {
                    var formData = new FormData(); // Создаем объект FormData

                    formData.append('icon', fileInput1.files[0]); // Добавляем первое изображение в FormData
                    formData.append('image', fileInput2.files[0]); // Добавляем второе изображение в FormData
                    formData.append('name', $('#platform-name').val()); // Добавляем название платформы в FormData
                    formData.append('full_name', $('#platform-full-name').val()); // Добавляем полное название платформы в FormData

                    console.log(formData)

                    $.ajax({
                        type: "POST", // METHOD
                        url: "{{ route('platform_add') }}", // route
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            $('#success').html(response.message)
                        },
                        error: function (response) {
                            //console.log(response)
                            $.each(response.responseJSON.errors, function (name, messages) {
                                console.log(name)
                                $.each(messages, function (message) {
                                    $('#error').html(message)
                                })
                            })
                        }
                    });
                }
            });
        });

    </script>
@endsection
