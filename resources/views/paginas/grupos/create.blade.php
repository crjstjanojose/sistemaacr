@extends('layoutacr.layoutacr')

@section('titulo','Criar de Grupo')

@section('acao','Criação Grupo')

@section('conteudo')
<form action="{{ route('roles.store') }}" method="post" autocomplete="off">
    @csrf
    <div class="form-row mt-3">
        <div class="form-group col-md-2">
            <label for="name">Denominação</label>
        </div>
        <div class="form-group col-md-10">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="nome" name="name" required value="{{ old('name') }}"
                placeholder="Descrição da permissão">
            <span id="error-name" class="help-block text-danger">{{ $errors->first('name') }}</span>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-rcsuccess">&nbsp; <i class="fas fa-arrow-left"></i>
            &nbsp;Retornar</a>
            @can('grupos-criar')
            <button type="submit" class="btn btn-sm btn-rcprimary mx-2">Incluir &nbsp; <i class="fas fa-database"></i>
                &nbsp;
            </button>
            @endcan
    </div>

</form>
@endsection
