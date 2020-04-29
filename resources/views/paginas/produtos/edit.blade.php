@extends('layoutacr.layoutacr')

@section('titulo','Alterar Produto')

@section('acao','Edição Produto')

@section('conteudo')
<form action="{{ route('produtos.update',$produto->id) }}" method="post">
    @csrf
    @method('PATCH')

    <div class="form-row mt-3">
        <div class="form-group col-md-1">
            <label for="denominacao">Denominação</label>
        </div>
        <div class="form-group col-md-8">
            <input type="text" class="form-control @error('denominacao') is-invalid @enderror" id="denominacao"
                name="denominacao" required value="{{ old('denominacao') ?? $produto->denominacao }}"
                placeholder="Denominação do produto">
            <span id="error-denominacao" class="help-block text-danger">{{ $errors->first('denominacao') }}</span>
        </div>
        <div class="form-group col-md-1">
            <label for="preco">Preço</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control @error('preco') is-invalid @enderror" id="preco" name="preco"
                required value="{{ old('preco') ?? $produto->preco }}" placeholder="Código de barra">
            <span id="error-preco" class="help-block text-danger">{{ $errors->first('preco') }}</span>
        </div>
    </div>

    <div class="form-row mt-3">
        <div class="form-group col-md-1">
            <label for="codigo_barra">Cód.Barra</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control @error('codigo_barra') is-invalid @enderror" id="codigo_barra"
                name="codigo_barra" required value="{{ old('codigo_barra') ?? $produto->codigo_barra }}"
                placeholder="Código de barra">
            <span id="error-codigo_barra" class="help-block text-danger">{{ $errors->first('codigo_barra') }}</span>
        </div>
        <div class="form-group col-md-1">
            <label for="laboratorio_fornecedor">Laboratório</label>
        </div>
        <div class="form-group col-md-5">
            <input type="text" class="form-control @error('laboratorio_fornecedor') is-invalid @enderror"
                id="laboratorio_fornecedor" name="laboratorio_fornecedor" required
                value="{{ old('laboratorio_fornecedor') ?? $produto->laboratorio_fornecedor }}"
                placeholder="Código de barra">
            <span id="error-laboratorio_fornecedor"
                class="help-block text-danger">{{ $errors->first('laboratorio_fornecedor') }}</span>
        </div>
        <div class="form-group col-md-1">
            <label for="unidade">Unidade</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control @error('unidade') is-invalid @enderror" id="unidade" name="unidade"
                required value="{{ old('unidade') ?? $produto->unidade }}" placeholder="Código de barra">
            <span id="error-unidade" class="help-block text-danger">{{ $errors->first('unidade') }}</span>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route('produtos.index') }}" class="btn btn-sm btn-rcsuccess"> &nbsp;<i
                class="fas fa-arrow-left"></i>&nbsp;Retornar</a>
        @can('produtos-editar')
        <button type="submit" class="btn btn-sm btn-rcprimary mx-2">Atualizar&nbsp;<i
                class="fas fa-database"></i>&nbsp;</button>
        @endcan
    </div>

</form>
@endsection
