<!DOCTYPE html>
<html lang="pt-BR">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>{{ $parametros->titulo }}</h3>
            </div>
            <div class="card-body">
              <h5 class="card-title"><p>{{ $parametros->descricao }}</p></h5>
              <p class="card-text">{{ $parametros->solicitante }}</p>
            </div>
          </div>
    </div>
</body>
</html>
