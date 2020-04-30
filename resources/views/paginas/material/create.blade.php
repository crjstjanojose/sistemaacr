@extends('layoutacr.layoutacr')

@section('titulo','Pedido de Material')

@section('acao','Pedido de Materiais')

@section('conteudo')
<form action="{{ route('materiais.store') }}" method="post" autocomplete="off">
    @csrf

    <div class="form-row mt-3">
        <div class="form-group col-md-2">
            <label for="titulo">Título</label>
        </div>
        <div class="form-group col-md-10">
            <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="nome" name="titulo" required value="{{ old('titulo') }}"
                placeholder="Título da solicitação">
                <span id="error-titulo" class="help-block text-danger">{{ $errors->first('titulo') }}</span>
        </div>
    </div>

    <div class="form-row  mb-3">
        <label for="descricao">Descrição da Solicitação</label>
        <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" rows="10"
        name="descricao" placeholder="Descrição da solicitacao" required>{{ old('titulo') }}</textarea>
        <span id="error-descricao" class="help-block text-danger">{{ $errors->first('descricao') }}</span>
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route("materiais.index") }}" class="btn btn-sm btn-rcsuccess">&nbsp; <i
                class="fas fa-arrow-left"></i>
            &nbsp;Retornar</a>
            @can('encomendas-criar')
            <button type="submit" class="btn btn-sm btn-rcprimary mx-2">Incluir &nbsp; <i class="fas fa-database"></i>
                &nbsp;
            </button>
            @endcan
    </div>

</form>
@endsection
