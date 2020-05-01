@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="col-md-12">
                    <div class="card-body">
                        <h5 class="card-title text-center">Pendentes</h5>
                        @if ($pendentes > 0)
                        <a href="{{ route('encomendas.index') }}" class="btn btn-sm btn-rcsuccess d-block"> Total de Pendentes ( {{ $pendentes }} ) </a>
                        @else
                        <p class="text-center">Nenhum registro encontrado !</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="col-md-12">
                    <div class="card-body">
                        <h5 class="card-title text-center">Solicitadas</h5>
                        @if ($solicitadas > 0)
                        <a href="{{ route('encomendas.index.solicitadas') }}" class="btn btn-sm btn-rcprimary d-block"> Total de Solicitadas ( {{ $solicitadas }} )</a>
                        @else
                        <p class="text-center">Nenhum registro encontrado !</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="col-md-12">
                    <div class="card-body">
                        <h5 class="card-title text-center">Entregues</h5>
                        @if ($entregues > 0)
                        <a href="{{ route('encomendas.index.entregues') }}" class="btn btn-sm btn-rcbtnviolet d-block"> Total de Entregues ( {{ $entregues }} )</a>
                        @else
                        <p class="text-center">Nenhum registro encontrado !</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="col-md-12">
                    <div class="card-body">
                        <h5 class="card-title text-center">Solicitar Material</h5>
                        <a href="{{ route('materiais.create') }}" class="btn btn-sm btn-rcpurple d-block"> Solicitar Material </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
