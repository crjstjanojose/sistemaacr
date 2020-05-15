@extends('layoutacr.layoutacr')

@section('titulo','Alterar Aplicacao')

@section('acao','Edição Aplicação')

@section('conteudo')
<form action="{{ route('aplicacoes.update',$aplicacao->id) }}" method="post">
    @csrf
    @method('PATCH')

    <div class="form-row mt-3">
        <div class="form-group col-md-1">
            <label for="produto_id">Produto</label>
        </div>
        <div class="form-group col-md-8">
            <select id="produto_id" class="form-control @error('produto_id') is-invalid @enderror" name="produto_id">
                <option value="{{ old('produto_id') ??  $aplicacao->produto->id }}">{{ $aplicacao->produto->denominacao }}</option>
            </select>
            <span id="error-produto_id" class="help-block text-danger">{{ $errors->first('produto_id') }}</span>
        </div>
        <div class="form-group col-md-1">
            <label for="data_aplicacao">Aplicação</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="data_aplicacao" id="data_aplicacao"
                class="form-control @error('data_aplicacao') is-invalid @enderror" placeholder=" 99/99/9999" required
                value="{{ old('data_aplicacao') ?? $aplicacao->data_aplicacao }}" data-date-start-date="-3d" data-date-end-date="0d">
            <span id="error-data_aplicacao" class="help-block text-danger">{{ $errors->first('data_aplicacao') }}</span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-1">
            <label for="cliente">Cliente</label>
        </div>
        <div class="form-group col-md-5">
            <select id="cliente_id" class="form-control @error('cliente_id') is-invalid @enderror" name="cliente_id">
                <option value="{{ old('cliente_id') ??  $aplicacao->cliente_id }}">{{ $aplicacao->cliente->nome }}</option>
            </select>
            <span id="error-cliente_id" class="help-block text-danger">{{ $errors->first('cliente_id') }}</span>
        </div>
        <div class="form-group col-md-1">
            <label for="data_venda">Venda</label>
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="data_venda" id="data_venda"
                class="form-control @error('data_venda') is-invalid @enderror" placeholder=" 99/99/9999" required
                value="{{ old('data_venda') ?? $aplicacao->data_venda }}" data-date-start-date="-60d" data-date-end-date="0d">
            <span id="error-data_venda" class="help-block text-danger">{{ $errors->first('data_venda') }}</span>
        </div>
        <div class="form-group col-md-1">
            <label for="documento_fiscal">Cupom</label>
        </div>
        <div class="form-group col-md-2">
            <input type="number" name="documento_fiscal" id="documento_fiscal"
                class="form-control @error('documento_fiscal') is-invalid @enderror" required placeholder="Cupom"
                min="1" value="{{ old('documento_fiscal') ?? $aplicacao->documento_fiscal }}">
            <span id="error-documento_fiscal"
                class="help-block text-danger">{{ $errors->first('documento_fiscal') }}</span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-1">
            <label for="user_aplicacao">Aplicador</label>
        </div>
        <div class="form-group col-md-11">
            <select name="user_aplicacao" id="user_aplicacao" class="form-control @error('user_aplicacao') is-invalid @enderror">
                @foreach ($aplicadores as $aplicador)
                <option value="{{ $aplicador->id }}" {{ $aplicacao->user_aplicacao == $aplicador->id ? 'selected' : ' ' }}>{{ $aplicador->name }}</option>
                @endforeach
            </select>
            <span id="error-aplicador" class="help-block text-danger">{{ $errors->first('aplicador') }}</span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-1">
            <label for="observacao">Observação</label>
        </div>
        <div class="form-group col-md-11">
            <textarea class="form-control @error('observacao') is-invalid @enderror" id="observacao" rows="3"
                name="observacao" placeholder="Descrição da observação" >{{ old('observacao') ?? $aplicacao->observacao }}</textarea>
            <span id="error-observacao" class="help-block text-danger">{{ $errors->first('observacao') }}</span>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route('aplicacoes.index') }}" class="btn btn-sm btn-rcsuccess"> &nbsp;<i
                class="fas fa-arrow-left"></i>&nbsp;Retornar</a>
        @can('aplicacoes-editar')
        <button type="submit" class="btn btn-sm btn-rcprimary mx-2">Atualizar&nbsp;<i
                class="fas fa-database"></i>&nbsp;</button>
        @endcan
    </div>

</form>
@endsection


@push('scripts')

<script>

$('#data_aplicacao').datepicker({
        format: "dd/mm/yyyy"
        , autoclose: true
        , todayHighlight: true
    });
$('#data_venda').datepicker({
        format: "dd/mm/yyyy"
        , autoclose: true
        , todayHighlight: true
    });


    $(document).ready(function () {

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$("#produto_id").select2({
    ajax: {
        url: "{{  route('produtos.getprodutos.select') }}",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                _token: CSRF_TOKEN,
                search: params.term // search term
            };
        },
        processResults: function (response) {
            return {
                results: response
            };
        },
        cache: true
    }

});

$("#cliente_id").select2({
    ajax: {
        url: "{{  route('clientes.getclientes.select') }}",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                _token: CSRF_TOKEN,
                search: params.term // search term
            };
        },
        processResults: function (response) {
            return {
                results: response
            };
        },
        cache: true
    }

});



});

</script>

@endpush
