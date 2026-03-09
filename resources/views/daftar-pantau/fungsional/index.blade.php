@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Daftar Pantau Fungsional</h1>
        <p class="text-muted mt-1">Pilih kelas pelatihan untuk mulai mengelola dan memantau dokumen kepesertaan.</p>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 border-bottom">
        {{-- Menggunakan text-success (Hijau) agar sesuai dengan tema Fungsional di Dashboard --}}
        <h6 class="mb-0 fw-bold text-success"><i class="fas fa-list-ul me-2"></i>Daftar Kelas Aktif</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tablePantauFungsional" class="table table-bordered table-hover align-middle w-100">
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th class="text-start">Nama Pelatihan</th>
                        <th>Balai</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelas as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            
                            {{-- NAMA PELATIHAN --}}
                            <td class="text-start fw-bold text-dark">
                                {{ $item->pelatihan->nama_pelatihan ?? '-' }}
                            </td>
                            
                            {{-- BALAI DENGAN ICON --}}
                            <td>
                                <span class="text-secondary"><i class="fas fa-building me-1"></i> {{ $item->balai }}</span>
                            </td>
                            
                            {{-- TANGGAL FORMAT INDONESIA --}}
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1">
                                    <i class="fas fa-calendar-alt text-muted me-1"></i> 
                                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1">
                                    <i class="fas fa-calendar-check text-muted me-1"></i> 
                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}
                                </span>
                            </td>
                            
                            {{-- TOMBOL AKSI MODERN (Menggunakan btn-success) --}}
                            <td>
                                <a href="{{ route('daftar-pantau.fungsional.show', $item->id) }}"
                                   class="btn btn-sm btn-success rounded-pill px-3 shadow-sm transition-hover">
                                    Buka <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
    .transition-hover {
        transition: all 0.2s ease-in-out;
    }
    .transition-hover:hover {
        transform: translateY(-2px);
        /* Bayangan hijau lembut saat tombol di-hover */
        box-shadow: 0 4px 8px rgba(28, 200, 138, 0.3) !important; 
    }
</style>
@endpush

@endsection

@push('scripts')
<script>
$(function () {
    $('#tablePantauFungsional').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        },
        ordering: true, // Memastikan fitur urut kolom aktif
    });
});
</script>
@endpush