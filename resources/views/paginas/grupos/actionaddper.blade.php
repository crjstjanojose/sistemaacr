@can('grupos-atribuir-permissao')
<a class="btn btn-sm btn-rcbtnadd" href="{{ route('adiciona.permissao.grupo',$id) }}"
    title="Editar Registro [ {{ $name }} ]">
    <i class="fas fa-lock-open"></i></a>
@endcan
