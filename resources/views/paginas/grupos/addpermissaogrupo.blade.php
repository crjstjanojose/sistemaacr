@extends('layoutacr.layoutacr')

@section('titulo','Adicionar Permissão')

@section('acao','Adicionar Permissão')

@section('conteudo')
<form action="{{ route('adiciona.permissao.grupo',$role->id) }}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-md-12">
            <select name="permissions[]" id="permissions" multiple="multiple">
                @foreach ($permissions as $permission)
                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="d-flex justify-content-end my-2">
        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-rcsuccess">&nbsp;<i
                class="fas fa-arrow-left"></i>&nbsp; Retornar</a>
        @can('grupos-atribuir-permissao')
        <button type="submit" class="btn btn-sm btn-rcprimary mx-2">Salvar &nbsp;<i
            class="fas fa-database"></i>&nbsp;</button>
            @endcan
    </div>
</form>
@endsection

@push('scripts') <script>
    $('#permissions').bootstrapDualListbox({
        nonSelectedListLabel: '<b class="text-rcbtnprimary">Disponíveis</b>'
        , selectedListLabel: '<b class="text-rcsuccess">Adicionados</b>'
        , preserveSelectionOnMove: 'moved'
        , moveOnSelect: 'false'
        , selectorMinimalHeight: 300
        , initialfilterfrom: ''
        , moveSelectedLabel: 'Remove'
        , filterTextClear: 'Limpar Filtro'
        , filterPlaceHolder: 'Filtrar'
        , infoTextEmpty: '<b class="text-rcbtnorange">Nenhum registro encontrado'
        , infoText: '<b class="text-rcsuccess">Pesquisar</b>'
        , infoTextFiltered: '<span class="badge badge-warning">Filtro ativo</span> {0} de {1}'
    });

</script>
@endpush
