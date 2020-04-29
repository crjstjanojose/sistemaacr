@can('grupos-remover-usuario')
<a class="btn btn-sm btn-rcbtnremove" href="{{ route('remove.usuario.grupo',$id) }}"
    title="Editar Registro [ {{ $name }} ]">
    <i class="fas fa-user-minus"></i></a>
@endcan
