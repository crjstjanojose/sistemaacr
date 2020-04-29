@extends('layoutacr.layoutacr')

@section('titulo','Criar de Usuário')

@section('acao','Edição Usuário')

@section('conteudo')
<form action="{{ route('users.update',$user->id) }}" method="post" auto">
    @csrf
    @method('PATCH')
    <div class="form-row mt-3">
        <div class="form-group col-md-2">
            <label for="name">Nome</label>
        </div>
        <div class="form-group col-md-10">
            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="nome" name="name" required
                value="{{ old('name') ?? $user->name }}" placeholder="Nome do usuário">
            <span id="error-name" class="help-block text-danger">{{ $errors->first('name') }}</span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="email">E-mail</label>
        </div>
        <div class="form-group col-md-10">
            <input type="email" class="form-control @error('name') is-invalid @enderror" id="email" name="email" required
                value="{{ old('email') ?? $user->email }}" placeholder="Email do usuário">
            <span id="error-name" class="help-block text-danger">{{ $errors->first('email') }}</span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="situacao">Situação</label>
        </div>
        <div class="form-group col-md-10">
            <select name="status" id="status" class="form-control">
                <option value="Ativo" {{ $user->status == 'Ativo' ? 'selected' : '' }}> Ativo</option>
                <option value="Inativo" {{ $user->status == 'Inativo' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-rcsuccess"> &nbsp;<i
                class="fas fa-arrow-left"></i>&nbsp;Retornar</a>
        <button type="submit" class="btn btn-sm btn-rcprimary mx-2">Atualizar&nbsp;<i
                class="fas fa-database"></i>&nbsp;</button>
    </div>
</form>
@endsection
