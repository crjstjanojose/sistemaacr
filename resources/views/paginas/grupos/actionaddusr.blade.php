@can('grupos-atribuir-usuario')
<a class="btn btn-sm btn-rcbtnadd" href="{{ route('adiciona.usuario.grupo',$id) }}"
    title="Editar Registro [ {{ $name }} ]">
    <i class="fas fa-user-plus"></i></a>
@endcan
