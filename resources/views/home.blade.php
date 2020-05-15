@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="row mt-5">
        <div class="col-md-10 offset-md-1">
            <div class="list-group list-group-horizontal">
                @can('clientes-criar')
                <a href="{{ route('clientes.create') }}" class="list-group-item list-group-item-action text-center">
                    <h5>Cadastrar
                        Cliente</h5>
                </a>
                @endcan
                @can('aplicacoes-criar')
                <a href="{{ route('aplicacoes.create') }}" class="list-group-item list-group-item-action  text-center">
                    <h5>Registrar
                        Aplicação</h5>
                </a>
                @endcan
                @can('materiais-criar')
                <a href="{{ route('materiais.create') }}" class="list-group-item list-group-item-action  text-center">
                    <h5>Solicitar
                        Material</h5>
                </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="row">
        @can('encomendas-listar-pendentes')
        <div class="col-md-4">
            <div class="card mb-1">
                <div class="col-md-12">
                    <div class="card-body">
                        <h5 class="card-title text-center">Pendentes</h5>
                        @if ($pendentes > 0)
                        <a href="{{ route('encomendas.index') }}" class="btn btn-sm btn-rcsuccess d-block"> Total de
                            Pendentes ( {{ $pendentes }} ) </a>
                        @else
                        <p class="text-center">Nenhum registro encontrado !</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endcan
        @can('encomendas-listar-solicitadas')
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="col-md-12">
                    <div class="card-body">
                        <h5 class="card-title text-center">Solicitadas</h5>
                        @if ($solicitadas > 0)
                        <a href="{{ route('encomendas.index.solicitadas') }}" class="btn btn-sm btn-rcprimary d-block">
                            Total de Solicitadas ( {{ $solicitadas }} )</a>
                        @else
                        <p class="text-center">Nenhum registro encontrado !</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endcan
        @can('encomendas-listar-entregues')
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="col-md-12">
                    <div class="card-body">
                        <h5 class="card-title text-center">Entregues</h5>
                        @if ($entregues > 0)
                        <a href="{{ route('encomendas.index.entregues') }}" class="btn btn-sm btn-rcbtnviolet d-block">
                            Total de Entregues ( {{ $entregues }} )</a>
                        @else
                        <p class="text-center">Nenhum registro encontrado !</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
    {{--
    <div class="row">
        @can('materiais-listar')
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="col-md-12">
                    <div class="card-body">
                        <h5 class="card-title text-center">Solicitar Material</h5>
                        <a href="{{ route('materiais.create') }}" class="btn btn-sm btn-rcpurple d-block"> Solicitar
    Material </a>
</div>
</div>
</div>
</div>
@endcan
@can('clientes-listar')
<div class="col-md-4">
    <div class="card mb-3">
        <div class="col-md-12">
            <div class="card-body">
                <h5 class="card-title text-center">Cadastrar Cliente</h5>
                <a href="{{ route('clientes.create') }}" class="btn btn-sm btn-rcbtnviolet d-block"> Cadastrar Cliente
                </a>
            </div>
        </div>
    </div>
</div>
@endcan
@can('aplicacoes-listar')
<div class="col-md-4">
    <div class="card mb-3">
        <div class="col-md-12">
            <div class="card-body">
                <h5 class="card-title text-center">Registrar Aplicações</h5>
                <a href="{{ route('aplicacoes.create') }}" class="btn btn-sm btn-rcsuccess d-block"> Registrar
                    Aplicações </a>
            </div>
        </div>
    </div>
</div>
@endcan
--}}


</div>
</div>
@endsection
