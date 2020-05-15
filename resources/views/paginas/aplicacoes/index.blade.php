@extends('layoutacr.layoutacr')

@section('titulo','Lista de Aplicações')

@section('acao','Aplicações')


@section('ferramentas')
<div class="col-md-6 d-flex justify-content-end my-2">
    <div class="btn-group" role="group" aria-label="Basic example">
        @can('aplicacoes-criar')
        <a href="{{ route('aplicacoes.create') }}" class="btn btn-rcsecondary">Novo&nbsp;<i class="fas fa-plus"></i>
        </a>
        @endcan
    </div>
</div>
@endsection


@section('conteudo')
<table class="table table-striped table-sm table-hover table-bordered my-2" id="indexcaracteristicas">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Cliente</th>
            <th>Data</th>
            <th>Aplicador</th>
            <th>Produto</th>
            <th width="3%"></th>
            <th width="3%"></th>
        </tr>
    </thead>
</table>
@endsection

@section('registro')

@endsection


@push('scripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    $('#indexcaracteristicas').DataTable({
        serverSide: false
        , processing: true
        , "ajax": "{{ route('index.aplicacoes') }}"
        , "columns": [{
                data: 'id'
            }
            , {
                data: 'nome'
            }
            , {
                data: 'data_aplicacao'
            }
            , {
                data: 'name'
            }
            , {
                data: 'denominacao'
            },
            {
                data: "btnedit",
                name: "btnedit",
                orderable: false,
                searchable: false
            },
            {
                data: "btndel",
                name: "btndel",
                orderable: false,
                searchable: false
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


    function deleteData(id) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        swal({
            title: "Confirma a exclusão ?",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(willDelete => {
            if (willDelete) {
                $.ajax({
                    url: "aplicacoes/" + id,
                    type: "POST",
                    data: { _method: "DELETE", _token: CSRF_TOKEN },
                    success: function (data) {
                        $("#indexcaracteristicas")
                            .DataTable()
                            .ajax.reload();
                        swal("Registro removido !", {
                            icon: "success"
                        });
                    },
                    error: function () {
                        swal({
                            title: "Ops ! Ocorreu um erro ao tentar excluir !",
                            text: data.message,
                            type: "error",
                            timer: "1500"
                        });
                    }
                });
            }
        });
    }

</script>
@endpush


{{--  {
                data: "btnedit",
                name: "btnedit",
                orderable: false,
                searchable: false
            },
            {
                data: "btndel",
                name: "btndel",
                orderable: false,
                searchable: false
            } --}}
