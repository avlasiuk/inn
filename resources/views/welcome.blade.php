<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .content {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="flex-center full-height">
            <div class="content">
                <form method="POST" action="{{ route('check') }}">
                    <div class="form-group form">
                        <input
                            name="inn"
                            class="form-control form__input"
                            placeholder="ИНН"
                            required
                        >
                        @if(session()->get('result'))
                            <div class="form__result">
                                {{ session()->get('result') }}
                            </div>
                        @endif
                        @if(session()->get('error'))
                            <div class="form__error">
                                {{ session()->get('error')->message }} (code: {{ session()->get('error')->code }} )
                            </div>
                        @endif
                        <button
                            type="submit"
                            class="form__button btn btn-primary">
                            Проверить
                        </button>
                        {{ csrf_field() }}
                    </div>
                </form>
            </div>
        </div>

        <script src="{{ asset('/js/app.js') }}"></script>
    </body>
</html>
