@can('aplicacoes-editar')
<a class="btn btn-sm btn-rcbtnedit text-white" href="{{ route('aplicacoes.edit',$id) }}"
    title="Editar Registro [ {{ $denominacao }} ]">
    <i class="fas fa-edit"></i></a>
@endcan
