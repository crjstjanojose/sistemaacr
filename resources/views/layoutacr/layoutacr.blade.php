<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ url('/css/app.css') }}">
    <link rel="stylesheet" href="{{ url('/css/custom.css') }}">
    <title>@yield('titulo')</title>
</head>

<body style="margin-top: 60px;">

    @include('layoutacr.navegacao')

    <div class="card">
        <div class="container-fluid">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="my-2">@yield('acao')</h5>
                    </div>
                    @yield('ferramentas')
                </div>
            </div>
        </div>
        <div class="card-body">
            @yield('conteudo')
        </div>
    </div>

    <script src="{{ url("/js/vendor.js") }}"></script>
    <script src="{{ url("/js/datatable.js") }}"></script>
    @stack('scripts')
    @include('sweetalert::alert')
</body>

</html>
