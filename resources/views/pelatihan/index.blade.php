@extends('layouts.app')

@section('content')

<h1 class="mt-4">Master Pelatihan</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Master Pelatihan</li>
</ol>

{{-- ========================= --}}
{{-- CARD 1 : TABEL CRUD --}}
{{-- ========================= --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Master Pelatihan
        </div>

    <div class="d-flex justify-content-start mt-3 px-3">
        <a href="{{ route('pelatihan.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Pelatihan
        </a>
    </div>


    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="tablePelatihan" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Pelatihan</th>
                        <th>Jenis</th>
                        <th>Tahun</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelatihan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_pelatihan }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $item->jenis_pelatihan }}
                                </span>
                            </td>
                            <td>{{ $item->tahun }}</td>
                            <td class="text-center">
                                <a href="{{ route('pelatihan.edit', $item->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('pelatihan.destroy', $item->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Data pelatihan belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ========================= --}}
{{-- CARD 2 : TABEL INFORMATIF --}}
{{-- ========================= --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <i class="fas fa-info-circle me-1"></i>
        Ringkasan Informasi Pelatihan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-borderless">
                <thead>
                    <tr class="text-muted">
                        <th>Pelatihan</th>
                        <th>Jenis</th>
                        <th>Tahun</th>
                        <th>Keterangan</th>
                        <th>Status Umum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelatihan as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->nama_pelatihan }}</strong><br>
                                <small class="text-muted">
                                    {{ $item->penyelenggara }}
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $item->jenis_pelatihan }}
                                </span>
                            </td>
                            <td>{{ $item->tahun }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                <span class="badge bg-success">
                                    Terdata
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#tablePelatihan').DataTable({
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50, 100],
            ordering: true,
            searching: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });
</script>
@endpush


@endsection
