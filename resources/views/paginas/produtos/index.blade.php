@extends('layoutacr.layoutacr')

@section('titulo','Lista de Produtos')

@section('acao','Produtos')


@section('ferramentas')
<div class="col-md-6 d-flex justify-content-end my-2">
    <div class="btn-group" role="group" aria-label="Basic example">
        @can('produtos-importar')
        <a href="{{ route('produtos.importar.view') }}" class="btn btn-rcsecondary">Importar</a>
        @endcan
    </div>
</div>
@endsection


@section('conteudo')
<table class="table table-striped table-sm table-hover table-bordered my-2" id="indexprodutos">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Cód. Barra</th>
            <th>Denominação</th>
            <th>Und</th>
            <th>Preço</th>
            <th>Fornecedor</th>
            <th></th>
        </tr>
    </thead>
</table>
@endsection

@section('registro')

@endsection


@push('scripts')
<script type="text/javascript">
    $('#indexprodutos').DataTable({

        serverSide: false
        , processing: true
        , "ajax": "{{ route('produtos.table.index') }}"
        //, dom: 'Bfrtip',
        //    buttons: [
        //      'excel', 'pdf',
        // ]
        , "columns": [{
            data: 'id'
        }
            , {
            data: 'codigo_barra'
        }
            , {
            data: 'denominacao'
        }
            , {
            data: 'unidade'
        }
            , {
            data: 'preco',
            render: $.fn.dataTable.render.number('.', ',', 2, '')
        }
            , {
            data: 'laboratorio_fornecedor'
        }
            , {
            data: 'btnedit'
            , name: 'btnedit'
            , orderable: false
            , searchable: false
        }
        ]
        , "language": {
            "info": "_TOTAL_ registro(s)"
            , "search": "<b>Pesquisar</b>"
            , "paginate": {
                "next": "Próximo"
                , "previous": "Anterior"

            }
            , "lengthMenu": '<b>Mostrar</b> <select>' +
                '<option value="-1">Todos</option>' +
                '<option value="5">5</option>' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="30">30</option>' +
                '<option value="40">40</option>' +
                '<option value="50">50</option>' +
                '</select> <b> registros</b>'
            , "loadingRecords": "Carregando ..."
            , "processing": "Aguarde ..."
            , "emptyTable": "Nenhum registro encontrado."
            , "zeroRecords": "Nenhum registro encontrado com esse argumento de busca."
            , "infoEmpty": ""
            , "infoFiltered": ""
        }


    });

    $.fn.dataTable.render.ellipsis = function (cutoff) {
        return function (data, type, row) {
            if (type === 'display') {
                var str = data.toString(); // cast numbers

                return str.length < cutoff ?
                    str :
                    str.substr(0, cutoff - 1) + '&#8230;';
            }

            // Search, order and type can use the original data
            return data;
        };

    };
</script>
@endpush
