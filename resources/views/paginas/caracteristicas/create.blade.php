@extends('layoutacr.layoutacr')

@section('titulo','Criar de Característica')

@section('acao','Criação Característica')

@section('conteudo')
<form action="{{ route('caracteristicas.store') }}" method="post" autocomplete="off">
    @csrf
    <div class="form-row mt-3">
        <div class="form-group col-md-2">
            <label for="denominacao">Denominação</label>
        </div>
        <div class="form-group col-md-10">
            <input type="text" class="form-control @error('denominacao') is-invalid @enderror" id="denominacao" name="denominacao" required value="{{ old('denominacao') }}"
                placeholder="Descrição da caracteristica">
                <span id="error-denominacao" class="help-block text-danger">{{ $errors->first('denominacao') }}</span>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route('caracteristicas.index') }}" class="btn btn-sm btn-rcsuccess">&nbsp; <i
                class="fas fa-arrow-left"></i>
            &nbsp;Retornar</a>
            @can('caracteristica-criar')
            <button type="submit" class="btn btn-sm btn-rcprimary mx-2">Incluir &nbsp; <i class="fas fa-database"></i>
                &nbsp;
            </button>
            @endcan
    </div>

</form>
@endsection
