@extends('layoutacr.layoutacr')

@section('titulo','Criar nova Encomenda')

@section('acao','Criação de Encomenda')

@section('conteudo')
<form action="{{ route('encomendas.store') }}" method="post" autocomplete="off">
    @csrf

    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="nome">Cliente</label>
                <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome"
                    required value="{{ old('nome') }}" placeholder="Nome do Cliente">
                <span id="error-nome" class="help-block text-danger">{{ $errors->first('nome') }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="contato">Contato</label>
                <input type="text" class="form-control @error('contato') is-invalid @enderror" id="contato"
                    name="contato" value="{{ old('contato') }}" placeholder="Contato">
                <span id="error-contato" class="help-block text-danger">{{ $errors->first('contato') }}</span>
            </div>
        </div>
    </div>

    <div class="row">
        {{--
        <div class="col-md-6">
            <div class="form-group">
                <label for="descricao">Produto</label>
                <input type="text" class="form-control @error('descricao') is-invalid @enderror" id="descricao"
                    name="descricao" value="{{ old('descricao') }}" placeholder="descricao da Encomenda">
        <span id="error-descricao" class="help-block text-danger">{{ $errors->first('descricao') }}</span>
    </div>
    </div>
    --}}
    <div class="col-md-6">
        <div class="form-group">
            <label for="produto_id">Produto</label>
            <select id="produto_id" class="form-control @error('produto_id') is-invalid @enderror" name="produto_id">
                <option value='0'>-- Selecione um Produto --</option>
            </select>
            <span id="error-produto_id" class="help-block text-danger">{{ $errors->first('produto_id') }}</span>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label for="quantidade">Quantidade</label>
        <input type="number" name="quantidade" id="quantidade"
            class="form-control @error('quantidade') is-invalid @enderror" required placeholder="Quantidade" min="1"
            value="{{ old('quantidade') }}">
        <span id="error-quantidade" class="help-block text-danger">{{ $errors->first('quantidade') }}</span>
    </div>

    <div class="form-group col-md-2">
        <label for="preco">Preço</label>
        <input type="text" name="preco" id="preco" class="form-control @error('preco') is-invalid @enderror"
            placeholder="Preço" value="{{ old('preco') }}" required>
    </div>

    <div class="form-group col-md-2">
        <label for="previsao">Previsão</label>
        <input type="text" name="previsao" id="previsao" class="form-control @error('previsao') is-invalid @enderror"
            placeholder=" 99/99/9999" data-date-start-date="0d" required value="{{ old('previsao') }}">
        <span id="error-previsao" class="help-block text-danger">{{ $errors->first('previsao') }}</span>
    </div>

    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label for="tipo_encomenda">Tipo da Encomenda</label>
            <select name="tipo_encomenda" id="tipo_encomenda" class="form-control">
                <option value="Encomenda">ENCOMENDA DE CLIENTE</option>
                <option value="Baixo">ESTOQUE BAIXO</option>
                <option value="Falta">FALTA NO ESTOQUE</option>
                <option value="Procura">PROCURA DEMANDA DE VENDA</option>
            </select>
            <span id="error-tipo_encomenda" class="help-block text-danger">{{ $errors->first('tipo_encomenda') }}</span>
        </div>
        <div class="col-md-6 form-group">
            <label for="caracteristica_id">Caracteristica</label>
            <select name="caracteristica_id" id="caracteristica_id" class="form-control">
                @foreach ($caracteristicas as $caracteristica)
                    <option value="{{ $caracteristica->id }}">{{ $caracteristica->denominacao }}</option>
                @endforeach
            </select>
            <span id="error-caracteristica" class="help-block text-danger">{{ $errors->first('caracteristica') }}</span>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route('encomendas.index') }}" class="btn btn-sm btn-rcsuccess">&nbsp; <i
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


@push('scripts')
<script>

    $('#previsao').datepicker({
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

    });


</script>
@endpush
