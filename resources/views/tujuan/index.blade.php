@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Master Data: Tujuan Penerima Surat</h1>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm border-0 border-top border-primary border-4 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-list me-1"></i> Daftar Tujuan Surat</h6>
        <a href="{{ route('tujuan-surat.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Data
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle w-100" id="tableTujuanSurat">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama Unit Organisasi</th>
                        <th>Nama Unit Kerja</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $item->nama_unitorganisasi }}</td>
                        <td>{{ $item->nama_unitkerja }}</td>
                        <td class="text-center text-nowrap">
                            <a href="{{ route('tujuan-surat.edit', $item->id) }}" class="btn btn-sm btn-warning text-white rounded-circle shadow-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('tujuan-surat.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger rounded-circle shadow-sm btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#tableTujuanSurat').DataTable({
            language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
            ordering: false
        });

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            let form = $(this).closest('form'); 
            
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b', 
                cancelButtonColor: '#858796', 
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true 
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); 
                }
            });
        });
    });
</script>
@endpush