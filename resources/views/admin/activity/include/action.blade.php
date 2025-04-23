<div class="d-flex">

    @can('show activity')
        <a class="btn btn-secondary me-2" href="{{ route('admin.activity.show', $id) }}"><i class="bx bx-show me-1"></i>
            Detail</a>
    @endcan

    @can('edit activity')
        @if ($status == 0)
            <a class="btn btn-warning me-2" href="{{ route('admin.activity.edit', $id) }}"><i class="bx bx-edit-alt me-1"></i>
                Edit</a>
        @endif

    @endcan

    @can('delete activity')
        @if ($status == 0)
            <form action="{{ route('admin.activity.destroy', $id) }}" method="POST" role="alert" alert-title="Hapus Data"
                alert-text="Yakin ingin menghapusnya?">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger me-2"><i class="bx bx-trash">Hapus</i>
                </button>
            </form>
        @endif
    @endcan
</div>
