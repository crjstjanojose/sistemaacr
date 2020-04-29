@extends('layoutacr.layoutacr')

@section('titulo','Importação de Produtos')

@section('acao','Importação de Registros - Produtos')


@section('conteudo')
<div class="container">
    <form action="{{ route('produtos.importar') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card mt-3">
            <div class="card-body">
                @can('produtos-importar')
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file-browser" name="arquivo">
                        <label class="custom-file-label" for="file-browser">Pesquisar...</label>

                    </div>
                </div>
                @endcan
            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href="{{ route('produtos.index') }}" class="btn btn-sm btn-rcsuccess mx-2">&nbsp; <i
                        class="fas fa-arrow-left"></i> &nbsp;Retornar</a>
            @can('produtos-importar')
            <button type="submit" class="btn btn-sm btn-rcprimary" id="btn-enviar">Importar &nbsp;<i
                class="fas fa-file-import"></i></button>
                @endcan
            </div>
        </div>
    </form>
</div>
@endsection
