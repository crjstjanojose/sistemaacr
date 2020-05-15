@can('clientes-excluir')
<button class="btn btn-sm btn-rcbtnremove text-white"
    title="Excluir Registro [ {{ $nome }} ]" onclick="deleteData({{ $id }})">
    <i class="fas fa-trash"></i>
    </button>
@endcan
