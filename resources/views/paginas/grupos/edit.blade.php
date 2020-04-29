@extends('layoutacr.layoutacr')

@section('titulo','Alterar Grupo')

@section('acao','Edição Grupo')

@section('conteudo')
<form action="{{ route('roles.update',$role->id) }}" method="post">
    @csrf
    @method('PATCH')
    <div class="form-row mt-3">
        <div class="form-group col-md-2">
            <label for="name">Nome</label>
        </div>
        <div class="form-group col-md-10">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="nome" name="name" required
                value="{{ old('name') ?? $role->name }}" placeholder="Nome do usuário">
            <span id="error-name" class="help-block text-danger">{{ $errors->first('name') }}</span>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-rcsuccess"> &nbsp;<i
                class="fas fa-arrow-left"></i>&nbsp;Retornar</a>
        @can('grupos-editar')
        <button type="submit" class="btn btn-sm btn-rcprimary mx-2">Atualizar&nbsp;<i
            class="fas fa-database"></i>&nbsp;</button>
        @endcan
    </div>

</form>
@endsection
