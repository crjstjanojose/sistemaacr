@extends('layoutacr.layoutacr')

@section('titulo','Lista de Permissões')

@section('acao','Permissões')


@section('ferramentas')
<div class="col-md-6 d-flex justify-content-end my-2">
    <div class="btn-group" role="group" aria-label="Basic example">
        @can('permissao-criar')
        <a href="{{ route('permissions.create') }}" class="btn btn-rcsecondary">Novo&nbsp;<i class="fas fa-plus"></i>
        </a>
        @endcan
    </div>
</div>
@endsection


@section('conteudo')
<table class="table table-striped table-sm table-hover table-bordered my-2" id="indexpermissions">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Descrição</th>
            <th width="3%"></th>
        </tr>
    </thead>
</table>
@endsection

@section('registro')

@endsection


@push('scripts')

<script type="text/javascript">
    $('#indexpermissions').DataTable({
        serverSide: false
        , processing: true
        , "ajax": "{{ route('permissions.table.index') }}"
        , "columns": [{
                data: 'id'
            }
            , {
                data: 'name'
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
            , "loadingRecords": "Carregando..."
            , "processing": "Processando..."
            , "emptyTable": "Nenhum registro encontrado."
            , "zeroRecords": "Nenhum registro encontrado com esse argumento de busca."
            , "infoEmpty": ""
            , "infoFiltered": ""
        }
    });

</script>
@endpush
