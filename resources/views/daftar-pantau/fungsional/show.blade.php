@extends('layouts.app')

@section('content')
<h1 class="mt-4">Detail Pemantauan Fungsional</h1>

{{-- CARD INFO KELAS (Sudah disesuaikan dengan isian form Kelas) --}}
<div class="row mb-4 mt-3">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 border-start border-success border-4">
            <div class="card-body">
                <h5 class="fw-bold text-success mb-1">
                    {{ $kelas->pelatihan->nama_pelatihan }} 
                    @if($kelas->angkatan) - <span class="text-dark">{{ $kelas->angkatan }}</span> @endif
                </h5>
                <p class="mb-1 text-muted"><i class="fas fa-building me-1"></i> Balai: {{ $kelas->balai }}</p>
                
                {{-- PENAMBAHAN DATA TOTAL PESERTA --}}
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

{{-- PESAN ERROR / SUCCESS --}}
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

{{-- TOMBOL TAMBAH & KEMBALI --}}
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('daftar-pantau.fungsional.index') }}" class="btn btn-secondary shadow-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
    @if(auth()->user()->isAdmin())
    <button id="btnTambahPantau" class="btn btn-success shadow-sm">
        <i class="fas fa-plus me-1"></i> Tambah Dokumen
    </button>
    @endif
</div>

{{-- FORM TAMBAH DATA (Disembunyikan default) --}}
<div id="formDaftarPantau" class="card shadow-sm border-0 mb-4 d-none">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 fw-bold text-success"><i class="fas fa-plus-circle me-1"></i> Form Tambah Dokumen</h6>
    </div>
    <div class="card-body">
        {{-- PASTIKAN NAMA FOLDER DISINI SESUAI DENGAN FOLDER ASLI ANDA --}}
        @include('daftar-pantau.fungsional.tabs.kepesertaan')
    </div>
</div>

{{-- TABEL DATA --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-success"><i class="fas fa-table me-1"></i> Riwayat Pemantauan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle" id="tableDetailPantau">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Jenis Pantau</th>
                        <th>PIC</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Pejabat TTD</th>
                        <th>Batas Waktu</th>
                        <th>Tujuan</th>
                        <th class="text-center">Lampiran</th>
                        @if(auth()->user()->isAdmin())
                        <th width="12%" class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($kepesertaan as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->jenis_pantau }}</td>
                        <td>{{ $item->pics }}</td>
                        <td>
                            @if($item->keterangan == 'Terkonfirmasi')
                                <span class="badge bg-success">{{ $item->keterangan }}</span>
                            @elseif($item->keterangan == 'Terkirim')
                                <span class="badge bg-info">{{ $item->keterangan }}</span>
                            @elseif($item->keterangan == 'Proses TTD')
                                <span class="badge bg-warning text-dark">{{ $item->keterangan }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $item->keterangan }}</span>
                            @endif
                        </td>
                        <td>{{ $item->keterangan_dua ?? '-' }}</td>
                        <td>{{ $item->pejabat_ttd }}</td>
                        <td>
                            @if($item->batas_waktu)
                                {{ \Carbon\Carbon::parse($item->batas_waktu)->translatedFormat('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $item->tujuan }}</td>
                        <td class="text-center">
                            @if($item->lampiran)
                                <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-file-download"></i> Lihat
                                </a>
                            @else
                                <span class="text-muted small">Tidak ada</span>
                            @endif
                        </td>
                        @if(auth()->user()->isAdmin())
                        <td class="text-center">
                            <a href="{{ route('pantau.fungsional.kepesertaan.edit', $item->id) }}" class="btn btn-sm btn-warning mb-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pantau.fungsional.kepesertaan.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger btn-delete mb-1" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
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
        $('#tableDetailPantau').DataTable({
            language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
            ordering: false,
        });

        $('#btnTambahPantau').on('click', function () {
            $('#formDaftarPantau').toggleClass('d-none');
            let icon = $(this).find('i');
            if($('#formDaftarPantau').hasClass('d-none')){
                icon.removeClass('fa-minus').addClass('fa-plus');
                $(this).removeClass('btn-secondary').addClass('btn-success');
            } else {
                icon.removeClass('fa-plus').addClass('fa-minus');
                $(this).removeClass('btn-success').addClass('btn-secondary');
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
                if (result.isConfirmed) {
                    form.submit(); 
                }
            });
        });
    });
</script>
@endpush