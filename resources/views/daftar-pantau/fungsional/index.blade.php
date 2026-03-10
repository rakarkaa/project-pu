@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Daftar Pantau Fungsional</h1>
        <p class="text-muted mt-1">Pilih kelas pelatihan untuk mulai mengelola dan memantau dokumen kepesertaan.</p>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-success"><i class="fas fa-list-ul me-2"></i>Daftar Kelas Aktif</h6>
        
        {{-- LOGIKA PHP UNTUK FILTER DINAMIS --}}
        @php
            // 1. Ambil data TAHUN dari tanggal_mulai (Unik & Urut ke bawah/Terbaru)
            $listTahun = $kelas->map(function($item) {
                return \Carbon\Carbon::parse($item->tanggal_mulai)->format('Y');
            })->unique()->sortDesc();

            // 2. Ambil data ANGKATAN (Unik & Urut abjad)
            $listAngkatan = $kelas->pluck('angkatan')->filter()->unique()->sort();
        @endphp

        {{-- AREA FILTER (TAHUN & ANGKATAN) --}}
        <div class="d-flex align-items-center gap-3">
            {{-- Filter Tahun --}}
            <div class="d-flex align-items-center">
                <label for="filterTahun" class="me-2 mb-0 fw-bold text-muted small"><i class="fas fa-calendar me-1"></i>Tahun:</label>
                <select id="filterTahun" class="form-select form-select-sm shadow-sm border-success text-success fw-bold" style="width: 130px; border-radius: 8px;">
                    <option value="">Semua Tahun</option>
                    @foreach($listTahun as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Angkatan --}}
            <div class="d-flex align-items-center">
                <label for="filterAngkatan" class="me-2 mb-0 fw-bold text-muted small"><i class="fas fa-users me-1"></i>Angkatan:</label>
                <select id="filterAngkatan" class="form-select form-select-sm shadow-sm border-success text-success fw-bold" style="width: 150px; border-radius: 8px;">
                    <option value="">Semua Angkatan</option>
                    @foreach($listAngkatan as $angkatan)
                        <option value="{{ $angkatan }}">{{ $angkatan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table id="tablePantauFungsional" class="table table-bordered table-hover align-middle w-100">
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">No</th>
                        {{-- Kolom Filter Tersembunyi --}}
                        <th>Kolom Tahun</th> 
                        <th>Kolom Angkatan</th> 
                        {{-- Kolom Tampil --}}
                        <th class="text-start">Nama Pelatihan</th>
                        <th>Angkatan</th>
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
                            
                            {{-- DATA FILTER TERSEMBUNYI UNTUK DATATABLES --}}
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('Y') }}</td>
                            <td>{{ $item->angkatan ?? '-' }}</td>
                            
                            {{-- TAMPILAN TABEL SEBENARNYA --}}
                            <td class="text-start fw-bold text-dark">
                                {{ $item->pelatihan->nama_pelatihan ?? '-' }}
                            </td>
                            <td class="fw-bold text-success">{{ $item->angkatan ?? '-' }}</td>
                            <td>
                                <span class="text-secondary"><i class="fas fa-building me-1"></i> {{ $item->balai }}</span>
                            </td>
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
        box-shadow: 0 4px 8px rgba(28, 200, 138, 0.3) !important;
    }
</style>
@endpush

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    // INISIALISASI DATATABLES
    var table = $('#tablePantauFungsional').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        },
        ordering: true, 
        columnDefs: [
            // Sembunyikan index 1 (Kolom Tahun) dan index 2 (Kolom Angkatan)
            { targets: [1, 2], visible: false } 
        ]
    });

    // 1. Eksekusi saat Dropdown Tahun diubah
    $('#filterTahun').on('change', function () {
        var val = $.fn.dataTable.util.escapeRegex($(this).val());
        // Filter spesifik di kolom index 1
        table.column(1).search(val ? '^' + val + '$' : '', true, false).draw();
    });

    // 2. Eksekusi saat Dropdown Angkatan diubah
    $('#filterAngkatan').on('change', function () {
        var val = $.fn.dataTable.util.escapeRegex($(this).val());
        // Filter spesifik di kolom index 2
        table.column(2).search(val ? '^' + val + '$' : '', true, false).draw();
    });
});
</script>
@endpush