@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mt-4 mb-2">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Monitoring Detail Pemantauan</h1>
        <p class="text-muted mt-1">Pantau progres setiap dokumen secara spesifik dan real-time.</p>
    </div>
</div>

<div class="card shadow-sm border-0 mb-5">
    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-satellite-dish me-2"></i> Status Dokumen Terkini</h6>
        
        {{-- LOGIKA PHP UNTUK FILTER DINAMIS --}}
        @php
            // 1. Ambil data TAHUN dari tanggal_mulai
            $listTahun = $semuaPemantauan->map(function($item) {
                return \Carbon\Carbon::parse($item->tanggal_mulai)->format('Y');
            })->unique()->sortDesc();

            // 2. Ambil data ANGKATAN
            $listAngkatan = $semuaPemantauan->pluck('angkatan')->filter()->unique()->sort();
        @endphp

        {{-- AREA TRIPLE FILTER --}}
        <div class="d-flex flex-wrap align-items-center gap-2">
            {{-- Filter Tahun --}}
            <select id="filterTahun" class="form-select form-select-sm shadow-sm border-secondary fw-bold text-secondary" style="width: 130px; border-radius: 8px;">
                <option value="">🗓️ Semua Tahun</option>
                @foreach($listTahun as $tahun)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
            </select>

            {{-- Filter Jenis Kelas --}}
            <select id="filterJenis" class="form-select form-select-sm shadow-sm border-secondary fw-bold text-secondary" style="width: 160px; border-radius: 8px;">
                <option value="">📚 Semua Jenis</option>
                <option value="Kepemimpinan">Kepemimpinan</option>
                <option value="Fungsional">Fungsional</option>
            </select>

            {{-- Filter Angkatan --}}
            <select id="filterAngkatan" class="form-select form-select-sm shadow-sm border-secondary fw-bold text-secondary" style="width: 160px; border-radius: 8px;">
                <option value="">👥 Semua Angkatan</option>
                @foreach($listAngkatan as $angkatan)
                    <option value="{{ $angkatan }}">{{ $angkatan }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table id="tableMonitoring" class="table table-bordered table-hover align-middle w-100" style="font-size: 0.9rem;">
                <thead class="table-light text-center align-middle">
                    <tr>
                        <th width="5%">No</th>
                        {{-- KOLOM FILTER TERSEMBUNYI --}}
                        <th>Kolom Tahun</th>
                        <th>Kolom Jenis</th>
                        <th>Kolom Angkatan</th>

                        <th class="text-start" width="22%">Informasi Kelas</th>
                        <th width="15%">Jadwal Pelaksanaan</th>
                        <th width="15%">Rincian Dokumen</th>
                        <th width="8%"><i class="fas fa-file-signature text-secondary d-block mb-1"></i> Susun</th>
                        <th width="8%"><i class="fas fa-pen-nib text-secondary d-block mb-1"></i> TTD</th>
                        <th width="8%"><i class="fas fa-paper-plane text-secondary d-block mb-1"></i> Kirim</th>
                        <th width="8%"><i class="fas fa-check-double text-secondary d-block mb-1"></i> Konfirm</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($semuaPemantauan as $i => $item)
                    <tr class="text-center transition-hover">
                        <td>{{ $i+1 }}</td>
                        
                        {{-- DATA FILTER TERSEMBUNYI --}}
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('Y') }}</td>
                        <td>{{ $item->jenis_kelas }}</td>
                        <td>{{ $item->angkatan ?? '-' }}</td>

                        {{-- INFORMASI KELAS (Nama + Angkatan & Badge) --}}
                        <td class="text-start">
                            <span class="fw-bold text-dark d-block mb-2">
                                {{ $item->nama_pelatihan }} 
                                @if(!empty($item->angkatan))
                                    <span class="text-primary">- {{ $item->angkatan }}</span>
                                @endif
                            </span>
                            
                            @if($item->jenis_kelas == 'Kepemimpinan')
                                <span class="badge bg-primary px-2 py-1 shadow-sm"><i class="fas fa-user-tie"></i> Kepemimpinan</span>
                            @else
                                <span class="badge bg-success px-2 py-1 shadow-sm"><i class="fas fa-clipboard-list"></i> Fungsional</span>
                            @endif
                        </td>

                        {{-- JADWAL MULAI & SELESAI --}}
                        <td class="text-start">
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-calendar-alt me-1 text-primary"></i> Mulai: <br> 
                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}</span>
                            </small>
                            <small class="text-muted d-block">
                                <i class="fas fa-calendar-check me-1 text-danger"></i> Selesai: <br> 
                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}</span>
                            </small>
                        </td>

                        {{-- RINCIAN DOKUMEN --}}
                        <td class="text-start">
                            <span class="fw-bold text-secondary d-block">{{ $item->jenis_pantau }}</span>
                            <small class="text-muted">Tujuan: {{ $item->tujuan }}</small>
                        </td>

                        {{-- INDIKATOR PROGRES TRACKER (DENGAN ANIMASI) --}}
                        <td>
                            @if($item->progress_level >= 1) 
                                <i class="fas fa-check-circle text-success fs-4 icon-pop"></i> 
                            @else 
                                <i class="fas fa-circle text-light fs-4 border rounded-circle shadow-sm"></i> 
                            @endif
                        </td>
                        <td>
                            @if($item->progress_level >= 2) 
                                <i class="fas fa-check-circle text-success fs-4 icon-pop"></i> 
                            @else 
                                <i class="fas fa-circle text-light fs-4 border rounded-circle shadow-sm"></i> 
                            @endif
                        </td>
                        <td>
                            @if($item->progress_level >= 3) 
                                <i class="fas fa-check-circle text-success fs-4 icon-pop"></i> 
                            @else 
                                <i class="fas fa-circle text-light fs-4 border rounded-circle shadow-sm"></i> 
                            @endif
                        </td>
                        <td>
                            @if($item->progress_level >= 4) 
                                <i class="fas fa-check-circle text-success fs-4 icon-pop"></i> 
                            @else 
                                <i class="fas fa-circle text-light fs-4 border rounded-circle shadow-sm"></i> 
                            @endif
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
    .transition-hover:hover {
        background-color: #f8f9fc !important;
    }
    .icon-pop {
        transition: transform 0.2s ease-in-out;
    }
    .icon-pop:hover {
        transform: scale(1.2);
    }
</style>
@endpush

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#tableMonitoring').DataTable({
            language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
            ordering: true, 
            pageLength: 10,
            columnDefs: [
                // Menyembunyikan 3 Kolom Filter Pertama (Index 1, 2, 3)
                { targets: [1, 2, 3], visible: false } 
            ]
        });

        // Eksekusi Filter Tahun (Index 1)
        $('#filterTahun').on('change', function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column(1).search(val ? '^' + val + '$' : '', true, false).draw();
        });

        // Eksekusi Filter Jenis Kelas (Index 2)
        $('#filterJenis').on('change', function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column(2).search(val ? '^' + val + '$' : '', true, false).draw();
        });

        // Eksekusi Filter Angkatan (Index 3)
        $('#filterAngkatan').on('change', function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column(3).search(val ? '^' + val + '$' : '', true, false).draw();
        });
    });
</script>
@endpush