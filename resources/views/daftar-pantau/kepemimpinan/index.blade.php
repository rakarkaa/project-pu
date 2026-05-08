@extends('layouts.app')

@section('content')
{{-- 1. HEADER HALAMAN (Responsive Flexbox) --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-4 mb-3 gap-2">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Daftar Pantau Kepemimpinan</h1>
        <p class="text-muted mt-1">Pilih kelas pelatihan untuk mulai mengelola dan memantau dokumen kepemimpinan.</p>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-list-ul me-2"></i>Daftar Kelas Aktif</h6>
        
        {{-- LOGIKA PHP UNTUK FILTER DINAMIS --}}
        @php
            $listTahun = $kelas->map(function($item) {
                return \Carbon\Carbon::parse($item->tanggal_mulai)->format('Y');
            })->unique()->sortDesc();

            $listAngkatan = $kelas->pluck('angkatan')->filter()->unique()->sort();
        @endphp

        {{-- AREA FILTER (Responsive Periode Tahun & Angkatan) --}}
        <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
            <div class="input-group input-group-sm" style="min-width: 280px;">
                <select id="filterTahunAwal" class="form-select border-primary text-primary fw-bold">
                    <option value="">Tahun Awal</option>
                    @foreach($listTahun as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>
                <span class="input-group-text bg-primary text-white border-primary">-</span>
                <select id="filterTahunAkhir" class="form-select border-primary text-primary fw-bold">
                    <option value="">Tahun Akhir</option>
                    @foreach($listTahun as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>

            <select id="filterAngkatan" class="form-select form-select-sm border-primary text-primary fw-bold" style="min-width: 150px;">
                <option value="">Semua Angkatan</option>
                @foreach($listAngkatan as $angkatan)
                    <option value="{{ $angkatan }}">{{ $angkatan }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle w-100" id="tablePantauKepemimpinan">
                <thead class="table-light text-nowrap">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th class="d-none">Tahun</th> {{-- Kolom Tersembunyi untuk Filter --}}
                        <th class="d-none">Angkatan</th> {{-- Kolom Tersembunyi untuk Filter --}}
                        <th>Nama Pelatihan</th>
                        <th>Angkatan</th>
                        <th>Balai</th>
                        <th>Pelaksanaan</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelas as $item)
                    <tr class="transition-hover">
                        <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                        <td class="d-none">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('Y') }}</td>
                        <td class="d-none">{{ $item->angkatan }}</td>
                        <td>
                            <div class="fw-bold text-primary">{{ $item->pelatihan->nama_pelatihan ?? '-' }}</div>
                            <small class="text-muted"><i class="fas fa-tag me-1"></i>Kepemimpinan</small>
                        </td>
                        <td>
                            @if($item->angkatan)
                                <span class="badge bg-light text-dark border px-3">Angkatan {{ $item->angkatan }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $item->balai }}</td>
                        <td class="text-nowrap">
                            <div class="small fw-semibold text-dark">
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}
                            </div>
                            <div class="small text-muted">
                                s/d {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('daftar-pantau.kepemimpinan.show', $item->id) }}" 
                               class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                                <i class="fas fa-eye me-1"></i> Detail
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
    .transition-hover { transition: all 0.2s ease-in-out; }
    .transition-hover:hover { background-color: rgba(78, 115, 223, 0.05); }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function () {
    var table = $('#tablePantauKepemimpinan').DataTable({
        language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
        ordering: true,
        responsive: true,
        columnDefs: [
            { targets: [1, 2], visible: false } 
        ]
    });

    // LOGIKA FILTER RENTANG TAHUN PERIODE
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = parseInt( $('#filterTahunAwal').val(), 10 );
            var max = parseInt( $('#filterTahunAkhir').val(), 10 );
            var year = parseFloat( data[1] ) || 0; 

            if ( ( isNaN( min ) && isNaN( max ) ) ||
                 ( isNaN( min ) && year <= max ) ||
                 ( min <= year   && isNaN( max ) ) ||
                 ( min <= year   && year <= max ) )
            {
                return true;
            }
            return false;
        }
    );

    $('#filterTahunAwal, #filterTahunAkhir').on('change', function () {
        table.draw();
    });

    $('#filterAngkatan').on('change', function () {
        var val = $.fn.dataTable.util.escapeRegex($(this).val());
        table.column(2).search(val ? '^' + val + '$' : '', true, false).draw();
    });
});
</script>
@endpush
@endsection