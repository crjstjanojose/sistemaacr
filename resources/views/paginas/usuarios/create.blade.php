@extends('layoutacr.layoutacr')

@section('titulo','Criar de Usuário')

@section('acao','Criação Usuário')

@section('conteudo')
<form action="{{ route('users.store') }}" method="post" autocomplete="off">
    @csrf
    <div class="form-row mt-3">
        <div class="form-group col-md-2">
            <label for="name">Nome</label>
        </div>
        <div class="form-group col-md-10">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="nome" name="name" required value="{{ old('name') }}"
                placeholder="Nome do usuário">
            <span id="error-name" class="help-block text-danger">{{ $errors->first('name') }}</span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="email">E-mail</label>
        </div>
        <div class="form-group col-md-10">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}"
                placeholder="Email do usuário">
                <span id="error-email" class="help-block text-danger">{{ $errors->first('email') }}</span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="password">Senha</label>
        </div>
        <div class="form-group col-md-10">
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required
                value="{{ old('password') }}" placeholder="Senha do usuário">
                <span id="error-email" class="help-block text-danger">{{ $errors->first('password') }}</span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="password">Confirme a senha </label>
        </div>
        <div class="form-group col-md-10">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                required " placeholder=" Confirme a senha do usuário">
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-rcsuccess">&nbsp;<i
                class="fas fa-arrow-left"></i>&nbsp; Retornar</a>
        <button type="submit" class="btn btn-sm btn-rcprimary mx-2">Incluir &nbsp;<i
                class="fas fa-database"></i>&nbsp;</button>
    </div>

</form>
@endsection
