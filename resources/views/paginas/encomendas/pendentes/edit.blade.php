@extends('layoutacr.layoutacr')

@section('titulo','Alterar Encomenda')

@section('acao','Edição Encomenda')

@section('conteudo')
<form action="{{ route('encomendas.update',$encomenda->id) }}" method="post">
    @csrf
    @method('PATCH')

    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="nome">Cliente</label>
                <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome"
                    required value="{{ old('nome') ?? $encomenda->nome  }}" placeholder="Nome do Cliente">
                <span id="error-nome" class="help-block text-danger">{{ $errors->first('nome') }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="contato">Contato</label>
                <input type="text" class="form-control @error('contato') is-invalid @enderror" id="contato"
                    name="contato" value="{{ old('contato') ?? $encomenda->contato }}" placeholder="Contato">
                <span id="error-contato" class="help-block text-danger">{{ $errors->first('contato') }}</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="produto_id">Produto</label>
                <select id='produto_id' class="form-control" name="produto_id">
                    <option value="{{ old('produto_id') ??  $encomenda->produto->id }}">{{ $encomenda->produto->denominacao }}</option>
                </select>
                <span id="error-produto_id" class="help-block text-danger">{{ $errors->first('produto_id') }}</span>
            </div>
        </div>

        <div class="form-group col-md-2">
            <label for="quantidade">Quantidade</label>
            <input type="number" name="quantidade" id="quantidade"
                class="form-control @error('quantidade') is-invalid @enderror" required placeholder="Quantidade" min="1"
                value="{{ old('quantidade') ?? $encomenda->quantidade }}">
            <span id="error-quantidade" class="help-block text-danger">{{ $errors->first('quantidade') }}</span>
        </div>

        <div class="form-group col-md-2">
            <label for="preco">Preço</label>
            <input type="text" name="preco" id="preco" class="form-control @error('preco') is-invalid @enderror"
                placeholder="Preço" value="{{ old('preco') ?? $encomenda->preco }}" required>
        </div>

        <div class="form-group col-md-2">
            <label for="previsao">Previsão</label>
            <input type="text" name="previsao" id="previsao"
                class="form-control @error('previsao') is-invalid @enderror" placeholder=" 99/99/9999"
                data-date-start-date="0d" required value="{{ old('previsao') ?? $encomenda->previsao}}">
            <span id="error-previsao" class="help-block text-danger">{{ $errors->first('previsao') }}</span>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label for="tipo_encomenda">Tipo da Encomenda</label>
            <select name="tipo_encomenda" id="tipo_encomenda" class="form-control">
                <option value="Encomenda" {{ $encomenda->tipo_encomenda == 'Encomenda' ? 'selected' : '' }}  >ENCOMENDA DE CLIENTE</option>
                <option value="Baixo" {{ $encomenda->tipo_encomenda == 'Baixo' ? 'selected' : '' }}>ESTOQUE BAIXO</option>
                <option value="Falta" {{ $encomenda->tipo_encomenda == 'Falta' ? 'selected' : '' }}>FALTA NO ESTOQUE</option>
                <option value="Procura" {{ $encomenda->tipo_encomenda == 'Procura' ? 'selected' : '' }}>PROCURA DEMANDA DE VENDA</option>
            </select>
            <span id="error-tipo_encomenda" class="help-block text-danger">{{ $errors->first('tipo_encomenda') }}</span>
        </div>
        <div class="col-md-6 form-group">
            <label for="caracteristica_id">Caracteristica</label>
            <select name="caracteristica_id" id="caracteristica_id" class="form-control">
                @foreach ($caracteristicas as $caracteristica)
                    <option value="{{ $caracteristica->id }}"  {{ $encomenda->caracteristica_id == $caracteristica->id ? 'selected' : '' }}>{{ $caracteristica->denominacao }}</option>
                @endforeach
            </select>
            <span id="error-caracteristica" class="help-block text-danger">{{ $errors->first('caracteristica') }}</span>
        </div>
    </div>


    <div class="d-flex justify-content-end">
        <a href="{{ route('encomendas.index') }}" class="btn btn-sm btn-rcsuccess"> &nbsp;<i
                class="fas fa-arrow-left"></i>&nbsp;Retornar</a>
        @can('encomendas-editar')
        <button type="submit" class="btn btn-sm btn-rcprimary mx-2">Atualizar&nbsp;<i
                class="fas fa-database"></i>&nbsp;</button>
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

    $(document).ready(function(){

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

      $( "#produto_id" ).select2({
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
