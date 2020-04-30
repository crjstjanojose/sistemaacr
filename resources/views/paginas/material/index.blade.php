@extends('layoutacr.layoutacr')

@section('titulo','Lista de Solicitações')

@section('acao','Solicitações de Materiais')


@section('ferramentas')
<div class="col-md-6 d-flex justify-content-end my-2">
    <div class="btn-group" role="group" aria-label="Basic example">
        @can('encomendas-criar')
        <a href="{{ route('materiais.create') }}" class="btn btn-rcsecondary">Nova&nbsp;<i class="fas fa-plus"></i>
        </a>
        @endcan
        @can('encomendas-criar')
        <button class="btn btn-rcsuccess" id="btnSolicitar">
            Comprar&nbsp;<i class="fas fa-check"></i>
        </button>
        @endcan
    </div>
</div>
@endsection


@section('conteudo')
<table class="table table-striped table-sm table-hover table-bordered my-2" id="indexmateriais">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center" width="20%">Data</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Solicitante</th>
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
    $('#indexmateriais').DataTable({
        serverSide: false
        , processing: true
        , "ajax": "{{ route('index.materiais') }}"
        , "columns": [{
                data: 'id'
            }
            , {
                data: 'created_at'
            }
            , {
                data: 'titulo'
            }
            , {
                data: 'descricao'
            }
            , {
                data: 'name'
            }
            , {
                data: "checkbox",
                name: "checkbox",
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
                text: "Confirma a solicitação da(s)compra(s) " + id.length  +  " selecionada(s) ?",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{ route('solicitacoes.confirma.multiplas') }}"
                             , method: "POST"
                             , data: {id: id, _token: CSRF_TOKEN}

                             , success: function(data) {

                                $('#indexmateriais').DataTable().ajax.reload();
                                    swal("Compras confirmadas com sucesso !", {
                                    icon: "success",
                                    });
                                 }
                        });

                    } else {
                        $('#indexmateriais').DataTable().ajax.reload();
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
