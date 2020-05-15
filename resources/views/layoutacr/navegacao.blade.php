<!-- Navegacao  -->
<nav class="navbar navbar-expand-lg navbar-dark bg-rcprimary fixed-top">
    <a class="navbar-brand" href="#">ACR</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link @if(request()->is('home')) active @endif" href="{{ route('home') }}">Dashboard</a>
            </li>
            @can('produtos-listar')
            <li class="nav-item">
                <a class="nav-link @if(request()->is('admin/produtos')) active @endif"
                    href="{{ route('produtos.index') }}">Produtos</a>
            </li>
            @endcan
            @can('encomendas-listar-pendentes')
            <li class="nav-item">
                <a class="nav-link @if(request()->is('admin/encomendas')) active @endif"
                    href="{{ route("encomendas.index") }}">Pendentes</a>
            </li>
            @endcan
            @can('encomendas-listar-solicitadas')
            <li class="nav-item">
                <a class="nav-link @if(request()->is('admin/indexsolicitadas')) active @endif"
                    href="{{ route('encomendas.index.solicitadas') }}">Solicitadas</a>
            </li>
            @endcan
            @can('encomendas-listar-entregues')
            <li class="nav-item">
                <a class="nav-link @if(request()->is('admin/indexentregues')) active @endif"
                    href="{{ route('encomendas.index.entregues') }}">Entregues</a>
            </li>
            @endcan

            @can('materiais-listar')
            <li class="nav-item">
                <a class="nav-link @if(request()->is('admin/materiais')) active @endif"
                    href="{{ route('materiais.index') }}">Materiais</a>
            </li>
            @endcan


            @can('caracteristica-listar')
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Tabelas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @can('caracteristica-listar')
                    <a class="dropdown-item" href="{{ route('caracteristicas.index') }}">Caracteristica</a>
                    @endcan
                    @can('clientes-listar')
                    <a class="dropdown-item" href="{{ route('clientes.index') }}">Clientes</a>
                    @endcan
                    @can('aplicacoes-listar')
                    <a class="dropdown-item" href="{{ route('aplicacoes.index') }}">Aplicações</a>
                    @endcan
                </div>
            </li>
            @endcan

            @can('controle-acesso-configuracoes')
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Configurações
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @can('usuario-listar')
                    <a class="dropdown-item" href="{{ route('users.index') }}">Usuarios</a>
                    @endcan
                    @can('permissao-listar')
                    <a class="dropdown-item" href="{{ route('permissions.index') }}">Permissões</a>
                    @endcan
                    @can('grupos-listar')
                    <a class="dropdown-item" href="{{ route('roles.index') }}">Grupos</a>
                    @endcan
                    <div class="dropdown-divider"></div>
                </div>
            </li>
            @endcan
        </ul>

        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
            @endif
            @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('alterar.senha') }}">
                        Alterar Senha
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @endguest
        </ul>
    </div>
</nav>
<!-- / Navegacao  -->
