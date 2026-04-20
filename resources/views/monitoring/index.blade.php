@extends('layouts.app')

@section('content')
{{-- ================================================================ --}}
{{-- 1. HEADER HALAMAN                                                --}}
{{-- ================================================================ --}}
<div class="d-flex justify-content-between align-items-center mt-4 mb-2">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Monitoring Detail Pemantauan</h1>
        <p class="text-muted mt-1">Pantau progres setiap dokumen secara spesifik dan real-time.</p>
    </div>
</div>

<div class="card shadow-sm border-0 mb-5">
    
    {{-- ================================================================ --}}
    {{-- 2. BAGIAN FILTER DINAMIS                                         --}}
    {{-- ================================================================ --}}
    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-satellite-dish me-2"></i> Status Dokumen Terkini</h6>
        
        {{-- LOGIKA PHP UNTUK MENYIAPKAN DATA DROPDOWN FILTER --}}
        @php
            // 1. Ambil data TAHUN dari tanggal_mulai
            $listTahun = $semuaPemantauan->map(function($item) {
                return \Carbon\Carbon::parse($item->tanggal_mulai)->format('Y');
            })->unique()->sortDesc();

            // 2. Ambil data Nama Pelatihan (Pengganti Angkatan)
            $listNamaPelatihan = $semuaPemantauan->pluck('nama_pelatihan')->filter()->unique()->sort();
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

            {{-- Filter Nama Pelatihan --}}
            <select id="filterNamaPelatihan" class="form-select form-select-sm shadow-sm border-secondary fw-bold text-secondary" style="width: 220px; border-radius: 8px;">
                <option value="">🎓 Semua Pelatihan</option>
                @foreach($listNamaPelatihan as $nama)
                    <option value="{{ $nama }}">{{ $nama }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    {{-- ================================================================ --}}
    {{-- 3. TABEL MONITORING UTAMA                                        --}}
    {{-- ================================================================ --}}
    <div class="card-body">
        <div class="table-responsive">
            <table id="tableMonitoring" class="table table-bordered table-hover align-middle w-100" style="font-size: 0.9rem;">
                <thead class="table-light text-center align-middle">
                    <tr>
                        <th width="3%">No</th>
                        
                        {{-- KOLOM FILTER TERSEMBUNYI (Index 1, 2, 3) --}}
                        <th>Kolom Tahun</th>
                        <th>Kolom Jenis</th>
                        <th>Kolom Nama Pelatihan</th>

                        <th class="text-start" width="25%">Informasi Kelas</th>
                        <th width="15%">Jadwal Pelaksanaan</th>
                        <th width="15%">Rincian Dokumen</th>
                        
                        {{-- KOLOM INDIKATOR PROGRES --}}
                        <th width="8%"><i class="fas fa-file-signature text-secondary d-block mb-1"></i> Susun </th>
                        <th width="8%"><i class="fas fa-pen-nib text-secondary d-block mb-1"></i> Tanda Tangan </th>
                        <th width="8%"><i class="fas fa-paper-plane text-secondary d-block mb-1"></i> Terkirim </th>
                        <th width="8%"><i class="fas fa-check-double text-secondary d-block mb-1"></i> Terkonfirmasi </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($semuaPemantauan as $i => $item)
                    
                    {{-- ------------------------------------------------ --}}
                    {{-- LOGIKA SMART DETECTOR & KONVERSI LEVEL PROGRES   --}}
                    {{-- ------------------------------------------------ --}}
                    @php
                        // 1. Amankan variabel (mencegah error Undefined property)
                        $keteranganTeks = $item->keterangan ?? '';
                        $statusPantauTeks = $item->status_pantau ?? '';

                        // 2. Deteksi apakah ini data format lama atau format baru
                        $isDataLama = in_array($keteranganTeks, ['Proses Penyusunan', 'Proses TTD', 'Terkirim', 'Terkonfirmasi']);
                        $teksStatus = $isDataLama ? $keteranganTeks : $statusPantauTeks;

                        // 3. Ubah teks status menjadi angka level agar ikon centang menyala berurutan
                        $progressLevel = 0;
                        if ($teksStatus == 'Proses Penyusunan') {
                            $progressLevel = 1;
                        } elseif ($teksStatus == 'Proses TTD') {
                            $progressLevel = 2;
                        } elseif ($teksStatus == 'Terkirim') {
                            $progressLevel = 3;
                        } elseif ($teksStatus == 'Terkonfirmasi') {
                            $progressLevel = 4;
                        }
                    @endphp

                    <tr class="text-center transition-hover">
                        {{-- Class nomor-urut dibutuhkan oleh JavaScript RowsGroup --}}
                        <td class="nomor-urut text-center text-muted fw-bold">{{ $item->nama_pelatihan }}</td>
                        
                        {{-- DATA FILTER TERSEMBUNYI --}}
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('Y') }}</td>
                        <td>{{ $item->jenis_kelas }}</td>
                        <td>{{ $item->nama_pelatihan }}</td>

                        {{-- INFORMASI KELAS (Hanya Nama Pelatihan) --}}
                        <td class="text-start">
                            <span class="fw-bold text-dark d-block mb-2">
                                {{ $item->nama_pelatihan }} 
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

                        {{-- ------------------------------------------------ --}}
                        {{-- INDIKATOR PROGRES TRACKER (MEMBACA $progressLevel)--}}
                        {{-- ------------------------------------------------ --}}
                        
                        {{-- Tahap 1: Konsep --}}
                        <td>
                            @if($progressLevel >= 1) 
                                <i class="fas fa-check-circle text-success fs-4 icon-pop"></i> 
                            @else 
                                <i class="fas fa-circle text-light fs-4 border rounded-circle shadow-sm"></i> 
                            @endif
                        </td>
                        
                        {{-- Tahap 2: Tanda Tangan --}}
                        <td>
                            @if($progressLevel >= 2) 
                                <i class="fas fa-check-circle text-success fs-4 icon-pop"></i> 
                            @else 
                                <i class="fas fa-circle text-light fs-4 border rounded-circle shadow-sm"></i> 
                            @endif
                        </td>
                        
                        {{-- Tahap 3: Terkirim --}}
                        <td>
                            @if($progressLevel >= 3) 
                                <i class="fas fa-check-circle text-success fs-4 icon-pop"></i> 
                            @else 
                                <i class="fas fa-circle text-light fs-4 border rounded-circle shadow-sm"></i> 
                            @endif
                        </td>
                        
                        {{-- Tahap 4: Terkonfirmasi --}}
                        <td>
                            @if($progressLevel >= 4) 
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

{{-- ================================================================ --}}
{{-- 4. GAYA (CSS) TAMBAHAN                                           --}}
{{-- ================================================================ --}}
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

{{-- ================================================================ --}}
{{-- 5. SCRIPT JAVASCRIPT & DATATABLES                                --}}
{{-- ================================================================ --}}
@push('scripts')
{{-- Panggil DataTables RowsGroup untuk menggabungkan baris yang sama --}}
<script src="https://cdn.jsdelivr.net/gh/ashl1/datatables-rowsgroup@v2.0.0/dataTables.rowsGroup.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#tableMonitoring').DataTable({
            language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
            ordering: true, 
            pageLength: 10,
            
            // Mematikan autoWidth agar lebar kolom dapat diatur manual
            autoWidth: false, 

            // Menggabungkan kolom 'Informasi Kelas' (index 4) lalu kolom 'No' (index 0)
            rowsGroup: [4, 0], 

            columnDefs: [
                // Sembunyikan 3 Kolom Filter Pertama
                { targets: [1, 2, 3], visible: false },
                
                // Atur lebar kolom
                { targets: 0, orderable: false, width: "3%" }, 
                { targets: 4, width: "25%" } 
            ],
            
            // Secara default urutkan tabel berdasarkan Informasi Kelas
            order: [[4, 'asc']],

            // Eksekusi penomoran ulang agar nomor urut rapi (1, 2, 3...)
            drawCallback: function (settings) {
                var api = this.api();
                var counter = api.context[0]._iDisplayStart + 1;

                $('#tableMonitoring tbody tr').each(function() {
                    var cell = $(this).find('.nomor-urut');
                    
                    if (cell.length > 0 && cell.is(':visible')) {
                        cell.html(counter); 
                        counter++;
                    }
                });
            }
        });

        // --- SCRIPT EKSEKUSI FILTER ---
        $('#filterTahun').on('change', function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column(1).search(val ? '^' + val + '$' : '', true, false).draw();
        });

        $('#filterJenis').on('change', function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column(2).search(val ? '^' + val + '$' : '', true, false).draw();
        });

        $('#filterNamaPelatihan').on('change', function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column(3).search(val ? '^' + val + '$' : '', true, false).draw();
        });
    });
</script>
@endpush