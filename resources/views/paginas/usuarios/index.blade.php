@extends('layoutacr.layoutacr')

@section('titulo','Lista de Usuários')

@section('acao','Usuários')


@section('ferramentas')
<div class="col-md-6 d-flex justify-content-end my-2">
    <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('users.create') }}" class="btn btn-rcsecondary">Novo&nbsp;<i class="fas fa-plus"></i>
        </a>
    </div>
</div>
@endsection


@section('conteudo')
<table class="table table-striped table-sm table-hover table-bordered my-2" id="indexusuarios">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Situação</th>
            <th width="3%"></th>
            <th width="3%"></th>
            <th width="3%"></th>
        </tr>
    </thead>
</table>
@endsection

@section('registro')

@endsection


@push('scripts')
<script type="text/javascript">
    $('#indexusuarios').DataTable({
        serverSide: false
        , processing: true
        , "ajax": "{{ route('usuarios.table.index') }}"
        , "columns": [{
                data: 'id'
            }
            , {
                data: 'name'
            }
            , {
                data: 'email'
            }
            , {
                data: 'status'
            }
            , {
                data: 'btnedit'
                , name: 'btnedit'
                , orderable: false
                , searchable: false
            },
            {
                  data: 'btnlibper'
                , name: 'btnlibper'
                , orderable: false
                , searchable: false
            },
            {
                  data: 'btnbloper'
                , name: 'btnbloper'
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
