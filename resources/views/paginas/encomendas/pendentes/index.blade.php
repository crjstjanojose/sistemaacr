@extends('layoutacr.layoutacr')
@section('titulo','Lista de Encomendas Pendentes')


@section('acao','Encomendas Pendentes') @section('ferramentas')
<div class="col-md-6 d-flex justify-content-end my-2">
    <div class="btn-group" role="group" aria-label="Basic example">
        @can('encomendas-criar')
        <a href="{{ route('encomendas.create') }}" class="btn btn-rcsecondary">Novo&nbsp; <i
                class="fas fa-plus"></i></a>
        @endcan
        @can('encomendas-listar-solicitadas')
        <a href="{{ route('encomendas.index.solicitadas') }}" class="btn btn-rcbtncyan">Solicitadas&nbsp; <i
                class="fas fa-industry"></i></a>
        @endcan
        @can('encomendas-listar-entregues')
        <a href="{{ route("encomendas.index.entregues") }}" class="btn btn-rcbtnviolet">Entregues&nbsp; <i
                class="fas fa-truck"></i></a>
        @endcan
        @can('encomendas-comprar')
        <button class="btn btn-rcsuccess" id="btnSolicitar">
            Comprar&nbsp;<i class="fas fa-check"></i>
        </button>
        @endcan
    </div>
</div>
@endsection

@section('conteudo')
<table class="table table-striped table-sm table-hover table-bordered my-2" id="encomendas-pendentes">
    <thead>
        <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Descrição</th>
            <th width="3%">Und</th>
            <th>Solicitação</th>
            <th>Característica</th>
            <th>Tipo</th>
            <th>Solicitante</th>
            <th width="3%"></th>
            <th width="3%"></th>
            <th width="1%"><input type="checkbox" id="checkTodos" name="checkTodos"></th>
        </tr>
    </thead>
</table>
@endsection

@section('registro')
@endsection

@push('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    $("#encomendas-pendentes").DataTable({
        serverSide: false,
        processing: true,
        ajax: "{{ route('encomendas.pendentes.table.index') }}",
        columns: [
            {
                data: "id"
            },
            {
                data: "nome"
            },
            {
                data: "denominacao"
            },
            {
                data: "quantidade"
            },
            {
                data: "created_at"
            },
            {
                data: "caracteristica"
            },
            {
                data: "tipo_encomenda"
            },
            {
                data: "name"
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
            },
            {
                data: "checkbox",
                name: "checkbox",
                orderable: false,
                searchable: false
            }
        ],
        language: {
            info: "_TOTAL_ registro(s)",
            search: "<b>Pesquisar</b>",
            paginate: {
                next: "Próximo",
                previous: "Anterior"
            },
            lengthMenu:
                '<b>Mostrar</b> <select>' +
                '<option value="-1">Todos</option>' +
                '<option value="5">5</option>' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="30">30</option>' +
                '<option value="40">40</option>' +
                '<option value="50">50</option>' +
                '</select> <b> registros</b>',
            loadingRecords: "Carregando...",
            processing: "Processando...",
            emptyTable: "Nenhum registro encontrado.",
            zeroRecords:
                "Nenhum registro encontrado com esse argumento de busca.",
            infoEmpty: "",
            infoFiltered: ""
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
                    url: "encomendas/" + id,
                    type: "POST",
                    data: { _method: "DELETE", _token: CSRF_TOKEN },
                    success: function (data) {
                        $("#encomendas-pendentes")
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

    $("#checkTodos__").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $("#checkTodos__").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    var checkTodos = $("#checkTodos");
    checkTodos.click(function () {
        if ($(this).is(':checked')) {
            $('input:checkbox').prop("checked", true);
        } else {
            $('input:checkbox').prop("checked", false);
        }
    });

    $(document).on('click', '#btnSolicitar', function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        var id = [];

        $('.check-multiplo:checked').each(function () {
            id.push($(this).val());
        });


        if (id.length > 0) {
            swal({
                text: "Confirma a solicitação da(s)encomenda(s) " + id.length  +  " selecionada(s) ?",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{ route('encomendas.confirma.multiplas.compras') }}"
                             , method: "POST"
                             , data: {id: id, _token: CSRF_TOKEN}

                             , success: function(data) {

                                $('#encomendas-pendentes').DataTable().ajax.reload();
                                    swal("Encomendas solicitadas com sucesso !", {
                                    icon: "success",
                                    });
                                 }
                        });

                    } else {
                        $('#encomendas-pendentes').DataTable().ajax.reload();
                        $('input:checkbox').prop("checked", false);
                        swal("Operação cancelada !");
                    }
                });
        } else {
            swal({

                text: " Nenhuma encomenda foi selecionada !",
                icon: "info",
                button: "OK",
            });
        }
    });
</script>
@endpush
