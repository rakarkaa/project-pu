@extends('layouts.app')

@section('content')
<div class="mt-4 mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Master Data Balai</h1>
    <p class="text-muted mt-1">Kelola direktori nama dan lokasi balai pelatihan yang tersedia di sistem.</p>
</div>

{{-- ========================= --}}
{{-- CARD 1 : TABEL CRUD UTAMA --}}
{{-- ========================= --}}
<div class="card shadow-sm border-0 mb-5">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-primary">
            <i class="fas fa-building me-2"></i>Data Master Balai
        </h6>
        
        @if(auth()->user()->isAdmin())
        <a href="{{ route('balai.create') }}" class="btn btn-primary btn-sm rounded-pill shadow-sm px-3">
            <i class="fas fa-plus me-1"></i> Tambah Balai
        </a>
        @endif
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle w-100" id="tableBalai">
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th class="text-start" width="30%">Nama Balai</th>
                        <th class="text-start">Keterangan</th>
                        @if(auth()->user()->isAdmin())
                        <th width="12%">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($balai as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start fw-bold text-dark">{{ $item->nama_balai }}</td>
                            <td class="text-start text-muted">{{ $item->keterangan ?? '-' }}</td>
                            
                            @if(auth()->user()->isAdmin())
                            <td>
                                <a href="{{ route('balai.edit', $item->id) }}"
                                   class="btn btn-sm btn-warning text-white rounded-circle shadow-sm me-1" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('balai.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger rounded-circle shadow-sm btn-delete" title="Hapus Data">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? '4' : '3' }}" class="text-center text-muted py-4">
                                <i class="fas fa-folder-open fs-3 d-block mb-2"></i>
                                Data balai belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ========================= --}}
{{-- CARD 2 : TABEL INFORMATIF (EXCEL STYLE + STICKY SCROLL) --}}
{{-- ========================= --}}
<div class="card shadow-sm border-0 mb-4 border-top border-info border-4">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-info">
            <i class="fas fa-file-excel me-2"></i>Ringkasan Data Balai (Tampilan Excel)
        </h6>
        <span class="badge bg-light text-secondary border"><i class="fas fa-compress-arrows-alt me-1"></i>Compact View</span>
    </div>

    <div class="card-body p-0"> 
        <div class="table-responsive custom-scrollbar" style="max-height: 350px; overflow-y: auto;">
            <table class="table table-sm table-bordered table-hover align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="table-light sticky-top shadow-sm text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th class="text-start" width="35%">Nama Balai</th>
                        <th class="text-start" width="45%">Keterangan</th>
                        <th width="15%">Status Umum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($balai as $item)
                        <tr class="text-center">
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td class="text-start fw-bold text-dark">{{ $item->nama_balai }}</td>
                            <td class="text-start text-muted text-truncate" style="max-width: 250px;" title="{{ $item->keterangan }}">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> Terdata
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-light py-2 text-center">
        <small class="text-muted"><i class="fas fa-mouse me-1"></i> Gulir di dalam kotak untuk melihat data lainnya</small>
    </div>
</div>
@endsection

@push('styles')
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1; 
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #c1c1c1; 
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8; 
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#tableBalai').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            ordering: true,
            language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" }
        });

        // SweetAlert2 untuk Delete
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            let form = $(this).closest('form'); 
            Swal.fire({
                title: 'Hapus Master Data?',
                text: "Data balai ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b', 
                cancelButtonColor: '#858796', 
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true 
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        });
    });
</script>
@endpush