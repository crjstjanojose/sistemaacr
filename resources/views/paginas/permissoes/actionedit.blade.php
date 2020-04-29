@can('permissao-editar')
<a class="btn btn-sm btn-rcbtnedit text-white" href="{{ route('permissions.edit',$id) }}"
    title="Editar Registro [ {{ $name }} ]">
    <i class="fas fa-edit"></i></a>
@endcan
