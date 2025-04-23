@extends('layouts.admin.index')

@section('title')
    Kegiatan
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard /</span> Kegiatan
        </h4>

        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.activity.index') }}"><i class="bx bx-arrow-back me-1"></i>
                    Kembali</a>
            </li>
            @if ($activity->status == 0)
                @can('verify activity')
                    <li class="nav-item">
                        <!-- Button to trigger modal -->
                        <button type="button" class="btn btn-warning mx-2" data-bs-toggle="modal"
                            data-bs-target="#validationModal">
                            <i class="bx bx-check me-1"></i> Validasi
                        </button>
                    </li>
                @endcan
            @endif
        </ul>

        <div class="card">
            <div class="card-body">
                <table class="table table-responsive-sm table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Pegawai</strong></td>
                            <td>
                                {{ $activity->user->name }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Nama Kegiatan</strong></td>
                            <td>
                                {{ $activity->activity }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Pelaksanaan</strong></td>
                            <td>
                                {{ \Carbon\Carbon::parse($activity->date)->isoFormat('dddd, D MMMM YYYY') }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Foto Kegiatan</strong></td>
                            <td>
                                <a href="{{ asset('storage/upload/kegiatan/' . $activity->photo) }}" target="blank"
                                    class="btn btn-dark btn-sm">
                                    <i class="bx bx-photo-album">
                                        Lihat Foto
                                    </i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                @if ($activity->status == 0)
                                    <span class="badge bg-warning">Pending</span>
                                @elseif ($activity->status == 1)
                                    <span class="badge bg-success">Disetuji Atasan</span>
                                @else
                                    <span class="badge bg-danger">Ditolak Atasan</span>
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Validation -->
    <div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="validationModalLabel">Validasi Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin memvalidasi kegiatan ini?</p>
                    <div class="d-flex">
                        <!-- Form for accepting the activity -->
                        <form action="{{ route('admin.activity.updateStatus', [$activity->id, 1]) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">
                                <i class="bx bx-check me-1"></i> Diterima
                            </button>
                        </form>

                        <!-- Form for rejecting the activity -->
                        <form action="{{ route('admin.activity.updateStatus', [$activity->id, 2]) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger mx-2">
                                <i class="bx bx-x me-1"></i> Ditolak
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
