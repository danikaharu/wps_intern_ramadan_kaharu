<div class="d-flex">
    @can('edit role')
        <a href="{{ route('admin.role.edit', $model->id) }}" class="btn btn-sm btn-warning text-white me-2">
            <i class="bx bx-edit"></i>
        </a>
    @endcan

    @can('delete role')
        <form action="{{ route('admin.role.destroy', $model->id) }}" method="POST" role="alert"
            alert-title="Hapus {{ $model->name }}" alert-text="Yakin ingin menghapusnya?">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm me-2"><i class="bx bx-trash me-1"></i>
            </button>
        </form>
    @endcan
</div>
