@extends('layouts.app')

@section('content')
{{-- ================================================================ --}}
{{-- 1. HEADER & INFORMASI KELAS (TEMA BIRU/PRIMARY)                  --}}
{{-- ================================================================ --}}
<h1 class="mt-4">Detail Pemantauan Kepemimpinan</h1>

<div class="row mb-4 mt-3">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 border-start border-primary border-4">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-1">
                    {{ $kelas->pelatihan->nama_pelatihan }} 
                    @if($kelas->angkatan) - <span class="text-dark">{{ $kelas->angkatan }}</span> @endif
                </h5>
                <p class="mb-1 text-muted"><i class="fas fa-building me-1"></i> Balai: {{ $kelas->balai }}</p>
                <p class="mb-1 text-muted"><i class="fas fa-users me-1"></i> Total Peserta: {{ $kelas->total_peserta }} Orang</p>
                <p class="mb-1 text-muted"><i class="fas fa-layer-group me-1"></i> Pola Penyelenggaraan: {{ $kelas->pola_penyelenggaraan }}</p>
                <p class="mb-0 text-muted">
                    <i class="fas fa-calendar-alt me-1"></i> 
                    {{ \Carbon\Carbon::parse($kelas->tanggal_mulai)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($kelas->tanggal_selesai)->translatedFormat('d M Y') }}
                </p>
            </div>
        </div>
    </div>
</div>

{{-- 2. NOTIFIKASI --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- 3. TOMBOL & FORM TAMBAH DATA (HANYA UNTUK ADMIN) --}}
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('daftar-pantau.kepemimpinan.index') }}" class="btn btn-secondary shadow-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
    @if(auth()->user()->isAdmin())
    <button id="btnTambahPantau" class="btn btn-primary shadow-sm rounded-pill px-4">
        <i class="fas fa-plus me-1"></i> Tambah Dokumen
    </button>
    @endif
</div>

@if(auth()->user()->isAdmin())
<div id="formDaftarPantau" class="card shadow-sm border-0 mb-4 d-none">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-plus-circle me-1"></i> Form Tambah Dokumen</h6>
    </div>
    <div class="card-body">
        @include('daftar-pantau.kepemimpinan.tabs.kepesertaan')
    </div>
</div>
@endif

{{-- ================================================================ --}}
{{-- 4. TABEL DATA PEMANTAUAN KEPEMIMPINAN                            --}}
{{-- ================================================================ --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-table me-1"></i> Riwayat Pemantauan</h6>
        
        @php
            $listTahunDokumen = $kepesertaan->map(function($item) {
                return \Carbon\Carbon::parse($item->created_at ?? now())->format('Y');
            })->unique()->sortDesc();
        @endphp

        <div class="d-flex align-items-center">
            <select id="filterTahun" class="form-select form-select-sm shadow-sm border-primary text-primary fw-bold" style="width: 140px; border-radius: 8px;">
                <option value="">Semua Tahun</option>
                @foreach($listTahunDokumen as $tahun)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle w-100" id="tableDetailPantau" style="font-size: 0.9rem;">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th class="d-none">Tahun</th>
                        <th>Jenis Pantau</th>
                        <th>Deadline</th> 
                        <th>PIC</th>
                        <th>Indikator</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Pejabat TTD</th>
                        <th>Batas Waktu</th> 
                        <th>Tujuan</th>
                        <th class="text-center">Lampiran</th>
                        @if(auth()->user()->isAdmin())
                            <th width="10%" class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($kepesertaan as $item)
                    @php
                        // A. Kalkulasi Deadline Pelatihan
                        $today = \Carbon\Carbon::now()->startOfDay();
                        $tanggalMulai = \Carbon\Carbon::parse($kelas->tanggal_mulai)->startOfDay();
                        $diffDays = intval($today->diffInDays($tanggalMulai, false));
                        
                        $teksDeadline = $diffDays < 0 ? 'Lewat ' . abs($diffDays) . ' Hari' : $diffDays . ' Hari Lagi';
                        $warnaDeadline = $diffDays < 0 ? 'text-danger fw-bold' : 'text-secondary fw-bold';

                        // B. Status & Indikator (Asli)
                        $isDataLama = in_array($item->keterangan, ['Proses Penyusunan', 'Proses TTD', 'Terkirim', 'Terkonfirmasi']);
                        $teksStatus = $isDataLama ? $item->keterangan : $item->status_pantau;
                        $teksCatatan = $isDataLama ? $item->keterangan_dua : $item->keterangan;

                        $indikatorStatus = 'Pending';
                        $badgeClass = 'bg-warning text-dark';
                        if (in_array($teksStatus, ['Proses Penyusunan', 'Proses TTD'])) {
                            $badgeClass = 'bg-warning text-dark'; $indikatorStatus = 'Pending';
                        } elseif ($teksStatus == 'Terkirim') {
                            $badgeClass = 'bg-info text-dark'; $indikatorStatus = 'Pengiriman';
                        } elseif ($teksStatus == 'Terkonfirmasi') {
                            $badgeClass = 'bg-success text-white'; $indikatorStatus = 'Selesai';
                        }

                        // C. Logika Batas Waktu & Pewarnaan (Murni Angka)
                        $teksBatas = '-';
                        $warnaBatas = 'text-dark';

                        if (!empty($item->batas_waktu)) {
                            // Konversi tanggal dari database kembali ke sisa hari
                            $tglBatas = \Carbon\Carbon::parse($item->batas_waktu)->startOfDay();
                            $diffBatas = intval($today->diffInDays($tglBatas, false));
                            
                            $teksBatas = $diffBatas < 0 ? 'Lewat ' . abs($diffBatas) . ' Hari' : $diffBatas . ' Hari Lagi';

                            // Penentuan Warna: Merah jika pengerjaan melebihi deadline pelatihan
                            if ($diffDays < 0) {
                                $warnaBatas = 'text-danger fw-bold';
                            } else {
                                if ($diffBatas > $diffDays) {
                                    $warnaBatas = 'text-danger fw-bold';
                                } else {
                                    $warnaBatas = 'text-success fw-bold';
                                }
                            }
                        }
                        
                        $tahunInput = \Carbon\Carbon::parse($item->created_at ?? now())->format('Y');
                    @endphp

                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="d-none">{{ $tahunInput }}</td>
                        <td class="fw-bold">{{ $item->jenis_pantau }}</td>
                        
                        <td><span class="{{ $warnaDeadline }}">{{ $teksDeadline }}</span></td>
                        
                        <td>{{ $item->pic ?? '-' }}</td>
                        <td><span class="badge {{ $badgeClass }} shadow-sm px-2 py-1">{{ $indikatorStatus }}</span></td>
                        <td>{{ $teksStatus ?? '-' }}</td> 
                        <td>{{ $teksCatatan ?? '-' }}</td> 
                        <td>{{ $item->pejabat_ttd ?? '-' }}</td>
                        
                        {{-- KOLOM BATAS WAKTU DENGAN WARNA OTOMATIS --}}
                        <td class="text-nowrap text-center">
                            @if($item->batas_waktu)
                                <span class="{{ $warnaBatas }}">{{ $teksBatas }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>{{ $item->tujuan }}</td>
                        <td class="text-center">
                            @if($item->lampiran)
                                <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="fas fa-file-pdf"></i> Lihat</a>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        @if(auth()->user()->isAdmin())
                        <td class="text-center text-nowrap">
                            <a href="{{ route('pantau.kepesertaan.edit', $item->id) }}" class="btn btn-sm btn-warning text-white rounded-circle shadow-sm mb-1"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('pantau.kepesertaan.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger rounded-circle shadow-sm mb-1 btn-delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                        @endif
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
        var table = $('#tableDetailPantau').DataTable({
            language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
            ordering: false,
            columnDefs: [ { targets: [1], visible: false } ]
        });

        $('#filterTahun').on('change', function () { 
            table.column(1).search(this.value).draw(); 
        });

        $('#btnTambahPantau').on('click', function () {
            $('#formDaftarPantau').toggleClass('d-none');
            let icon = $(this).find('i');
            if($('#formDaftarPantau').hasClass('d-none')){
                icon.removeClass('fa-minus').addClass('fa-plus');
                $(this).removeClass('btn-secondary').addClass('btn-primary');
            } else {
                icon.removeClass('fa-plus').addClass('fa-minus');
                $(this).removeClass('btn-primary').addClass('btn-secondary');
            }
        });

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            let form = $(this).closest('form'); 
            Swal.fire({
                title: 'Hapus Dokumen?',
                text: "Data pemantauan ini akan dihapus secara permanen!",
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