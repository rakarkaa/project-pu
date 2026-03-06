@extends('layouts.app')

@section('content')
<h1 class="mt-4">Detail Pemantauan Kepemimpinan</h1>

{{-- CARD INFO KELAS --}}
<div class="row mb-4 mt-3">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 border-start border-primary border-4">
            <div class="card-body">
                <h5 class="fw-bold text-primary mb-1">
                    {{ $kelas->pelatihan->nama_pelatihan }}
                </h5>
                <p class="mb-1 text-muted"><i class="fas fa-building me-1"></i> Balai: {{ $kelas->balai }}</p>
                <p class="mb-0 text-muted">
                    <i class="fas fa-calendar-alt me-1"></i> 
                    {{ \Carbon\Carbon::parse($kelas->tanggal_mulai)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($kelas->tanggal_selesai)->format('d M Y') }}
                </p>
            </div>
        </div>
    </div>
</div>

{{-- PESAN ERROR / SUCCESS --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> Silakan periksa isian form Anda:
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- FORM TAMBAH DATA (Hidden by default) --}}
@if(auth()->user()->isAdmin())
<div class="mb-4">
    <button id="btnTambahPantau" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus me-1"></i> Tambah Data Pemantauan
    </button>
    
    <div id="formDaftarPantau" class="card mt-3 mb-4 d-none text-start shadow-sm border-0">
        <div class="card-header bg-light">
            <h6 class="mb-0 fw-bold"><i class="fas fa-file-alt me-1"></i> Form Input Pemantauan</h6>
        </div>
        <div class="card-body bg-white">
            {{-- Mengambil form kepesertaan secara langsung (tanpa Tab) --}}
            @include('daftar-pantau.kepemimpinan.tabs.kepesertaan')
        </div>
    </div>
</div>
@endif

{{-- ============================== --}}
{{-- DATA PEMANTAUAN KEPEMIMPINAN   --}}
{{-- ============================== --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-list me-1"></i> Data Pemantauan Kepemimpinan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tableKepesertaan" class="table table-bordered table-hover table-striped align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Total Peserta</th>
                        <th>Jenis Pantau</th>
                        <th>Deadline</th> 
                        <th>Indikator Status</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Pejabat TTD</th>
                        <th>Batas Waktu</th> 
                        <th>Tujuan</th>
                        <th>Scan Dokumen</th>
                        @if(auth()->user()->isAdmin())
                            <th class="text-center" width="10%">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($kepesertaan as $item)
                    @php
                        $today = \Carbon\Carbon::now()->startOfDay();
                        $tanggalMulai = \Carbon\Carbon::parse($kelas->tanggal_mulai)->startOfDay();
                        
                        // 1. Deadline Otomatis
                        $diffDays = intval($today->diffInDays($tanggalMulai, false));
                        $deadline = $diffDays < 0 ? 'Lewat ' . abs($diffDays) . ' Hari' : 'H-' . $diffDays;

                        // 2. Indikator Status
                        $indikatorStatus = 'Pending';
                        $badgeClass = 'bg-warning text-dark';
                        if (in_array($item->keterangan, ['Proses Penyusunan', 'Proses TTD'])) {
                            $indikatorStatus = 'Pending';
                            $badgeClass = 'bg-warning text-dark';
                        } elseif ($item->keterangan == 'Terkirim') {
                            $indikatorStatus = 'Pengiriman';
                            $badgeClass = 'bg-info text-dark';
                        } elseif ($item->keterangan == 'Terkonfirmasi') {
                            $indikatorStatus = 'Selesai';
                            $badgeClass = 'bg-success';
                        }

                        // 3. Batas Waktu
                        $displayBatasWaktu = '-';
                        if ($item->batas_waktu) {
                            $tglBatas = \Carbon\Carbon::parse($item->batas_waktu)->startOfDay();
                            $diffBatas = intval($today->diffInDays($tglBatas, false));
                            $displayBatasWaktu = $diffBatas < 0 ? 'Melebihi Batas' : 'H-' . $diffBatas;
                        }
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $item->total_peserta }}</td>
                        <td>{{ $item->jenis_pantau }}</td>
                        <td>{{ $deadline }}</td>
                        <td><span class="badge {{ $badgeClass }}">{{ $indikatorStatus }}</span></td>
                        <td>{{ $item->keterangan }}</td>
                        <td>{{ $item->keterangan_dua ?? '-' }}</td> 
                        <td>{{ $item->pejabat_ttd ?? '-' }}</td>
                        <td>{{ $displayBatasWaktu }}</td>
                        <td>{{ $item->tujuan }}</td>
                        <td class="text-center">
                            @if($item->lampiran)
                                <a href="{{ asset('storage/'.$item->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-file-pdf"></i> Lihat</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        @if(auth()->user()->isAdmin())
                        <td class="text-center">
                            {{-- TOMBOL EDIT SEKARANG MENGARAH KE HALAMAN BARU --}}
                            <a href="{{ route('pantau.kepesertaan.edit', $item->id) }}" class="btn btn-sm btn-warning mb-1" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pantau.kepesertaan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger mb-1" title="Hapus Data"><i class="fas fa-trash"></i></button>
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

@push('scripts')
<script>
$(document).ready(function () {
    $('#tableKepesertaan').DataTable({ 
        language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
        ordering: false // Opsional: mematikan sort otomatis jika ingin murni by input
    });

    // Script Toggle Form Tambah Data
    $('#btnTambahPantau').on('click', function () {
        $('#formDaftarPantau').toggleClass('d-none');
        let icon = $(this).find('i');
        if($('#formDaftarPantau').hasClass('d-none')){
            icon.removeClass('fa-minus').addClass('fa-plus');
        } else {
            icon.removeClass('fa-plus').addClass('fa-minus');
        }
    });
});
</script>
@endpush

@endsection