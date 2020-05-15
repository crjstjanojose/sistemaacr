@can('clientes-editar')
<a class="btn btn-sm btn-rcbtnedit text-white" href="{{ route('clientes.edit',$id) }}"
    title="Editar Registro [ {{ $nome }} ]">
    <i class="fas fa-edit"></i></a>
@endcan
