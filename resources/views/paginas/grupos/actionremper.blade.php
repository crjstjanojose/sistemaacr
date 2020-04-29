@can('grupos-remover-permissao')
<a class="btn btn-sm btn-rcbtnremove" href="{{ route('remove.permissao.grupo',$id) }}"
    title="Editar Registro [ {{ $name }} ]">
    <i class="fas fa-lock"></i></a>
@endcan
