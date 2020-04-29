<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
    <link rel="stylesheet" href="{{ asset("css/login.css") }}">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="{{ asset('img/logo.png') }}">
            <form class="form-signin" method="POST" action="{{ route('usuario.update.senha') }}">
                @csrf
                <div class="form-group">
                    <label class="">Senha Atual</label>
                    <input class="form-control @error('password') is-invalid @enderror" type="password"
                        placeholder="Senha" name="password" required>
                </div>
                <div class="form-group">
                    <label class="">Nova Senha</label>
                    <input class="form-control @error('confirma') is-invalid @enderror" type="password"
                        placeholder="Nova senha" name="nova" required>
                </div>
                <div class="form-group">
                    <label class="">Confirma Senha</label>
                    <input class="form-control @error('confirma') is-invalid @enderror" type="password"
                        placeholder="Confirmação" name="confirma" required>
                    <span id="error-confirma" class="help-block text-danger">{{ $errors->first('confirma') }}</span>
                </div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('home') }}" class="btn btn-primary btr-sm mb-4">Cancelar</a>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-success btr-sm mb-4" type="submit">Alterar</button>
                        </div>
                    </div>
                </div>
        </div>
        </form><!-- /form -->
    </div><!-- /card-container -->
    </div><!-- /container -->

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
