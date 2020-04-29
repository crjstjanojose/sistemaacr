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
            <form class="form-signin" method="POST" action="{{ route('login') }}">
                @csrf
                <span id="reauth-email" class="reauth-email"></span>
                <div class="form-group">
                    <label class="control-label">E-mail</label>
                    <input type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus name="email">
                </div>

                <div class="form-group">
                    <label class="control-label">Senha</label>
                    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" required name="password">
                </div>

                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> Lembrar me
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Acessar</button>
            </form><!-- /form -->
            <a href="#" class="forgot-password">
                Esqueceu a senha ?
            </a>
        </div><!-- /card-container -->
    </div><!-- /container -->

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
