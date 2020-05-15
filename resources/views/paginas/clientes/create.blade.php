@extends('layoutacr.layoutacr')

@section('titulo','Criar Cliente')

@section('acao','Criação Cliente')

@section('conteudo')
<form action="{{ route('clientes.store') }}" method="post" autocomplete="off">
    @csrf

    <div class="form-row mt-3">
        <div class="form-group col-md-1">
            <label for="nome">Nome</label>
        </div>
        <div class="form-group col-md-8">
            <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" required
                value="{{ old('nome') }}" placeholder="Nome do Cliente">
            <span id="error-nome" class="help-block text-danger">{{ $errors->first('nome') }}</span>
        </div>
        <div class="form-group col-md-1">
            <label for="nascimento">Nascimento</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="nascimento" id="nascimento"
                class="form-control @error('nascimento') is-invalid @enderror" placeholder=" 99/99/9999" required
                value="{{ old('nascimento') }}">
            <span id="error-nascimento" class="help-block text-danger">{{ $errors->first('nascimento') }}</span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-1">
            <label for="cpf">CPF</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf" name="cpf" required
                value="{{ old('cpf') }}" placeholder="CPF">
            <span id="error-cpf" class="help-block text-danger">{{ $errors->first('cpf') }}</span>
        </div>
        <div class="form-group col-md-1">
            <label for="rg">RG</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control @error('rg') is-invalid @enderror" id="rg" name="rg" required
                value="{{ old('rg') }}" placeholder="RG">
            <span id="error-rg" class="help-block text-danger">{{ $errors->first('rg') }}</span>
        </div>
        <div class="form-group col-md-1">
            <label for="celular">Celular</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control @error('celular') is-invalid @enderror" id="celular" name="celular"
                required value="{{ old('celular') }}" placeholder="Celular">
            <span id="error-celular" class="help-block text-danger">{{ $errors->first('celular') }}</span>
        </div>
        <div class="form-group col-md-1">
            <label for="telefone">Telefone</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control @error('telefone') is-invalid @enderror" id="telefone"
                name="telefone" value="{{ old('telefone') }}" placeholder="Telefone">
            <span id="error-telefone" class="help-block text-danger">{{ $errors->first('telefone') }}</span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-1">
            <label for="endereco">Endereço</label>
        </div>
        <div class="form-group col-md-4">
            <input type="text" class="form-control @error('endereco') is-invalid @enderror" id="endereco"
                name="endereco" required value="{{ old('endereco') }}" placeholder="Endereço">
            <span id="error-endereco" class="help-block text-danger">{{ $errors->first('endereco') }}</span>
        </div>
        <div class="form-group col-md-1">
            <label for="bairro">Bairro</label>
        </div>
        <div class="form-group col-md-3">
            <input type="text" class="form-control @error('bairro') is-invalid @enderror" id="bairro" name="bairro"
                required value="{{ old('bairro') }}" placeholder="Bairro">
            <span id="error-bairro" class="help-block text-danger">{{ $errors->first('bairro') }}</span>
        </div>

        <div class="form-group col-md-1">
            <label for="cidade">Cidade</label>
        </div>
        <div class="form-group col-md-2">
            <select name="cidade_id" id="cidade_id" class="form-control @error('cidade') is-invalid @enderror">
                @foreach ($cidades as $cidade)
                <option value="{{ $cidade->id }}">{{ $cidade->descricao }}</option>
                @endforeach
            </select>
            <span id="error-cidade" class="help-block text-danger">{{ $errors->first('cidade') }}</span>
        </div>
    </div>


    <div class="d-flex justify-content-end">
        <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-rcsuccess">&nbsp; <i
                class="fas fa-arrow-left"></i>
            &nbsp;Retornar</a>
        @can('clientes-criar')
        <button type="submit" class="btn btn-sm btn-rcprimary mx-2">Incluir &nbsp; <i class="fas fa-database"></i>
            &nbsp;
        </button>
        @endcan
    </div>

</form>
@endsection

@push('scripts')

<script>



</script>

@endpush
