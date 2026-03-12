@extends('layouts.app')

@section('content')

{{-- LOGIKA PHP: CEK SESI LOGIN --}}
@php
    $showModal = false;
    // Jika belum ada tanda 'sudah_lihat_popup' di session Laravel saat ini
    if (!session()->has('sudah_lihat_popup')) {
        $showModal = true;
        // Tandai bahwa user sudah melihatnya di sesi login ini
        session()->put('sudah_lihat_popup', true);
    }
@endphp

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Dashboard Terpadu</h1>
    <span class="text-muted"><i class="fas fa-clock me-1"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
</div>

{{-- ========================================================== --}}
{{-- 1. ALERT BANNER: PENGINGAT PERMANEN DI ATAS DASHBOARD        --}}
{{-- ========================================================== --}}
<div class="alert alert-warning alert-dismissible fade show shadow-sm border-0 border-start border-warning border-4 mb-4" role="alert" style="background-color: #fff8e5;">
    <div class="d-flex align-items-center">
        <div class="me-3">
            <i class="fas fa-bell fa-2x text-warning alert-icon-pulse"></i>
        </div>
        <div>
            <h6 class="alert-heading fw-bold text-dark mb-1">Perhatian! Tindak Lanjut Diperlukan</h6>
            <p class="mb-0 text-dark" style="font-size: 0.9rem;">
                Saat ini terdapat <strong>{{ $totalPending ?? 'beberapa' }} dokumen</strong> pemantauan yang masih berstatus <span class="badge bg-warning text-dark">Pending</span> dan mendekati batas waktu. Silakan periksa menu Daftar Pantau.
            </p>
        </div>
    </div>
    <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

{{-- BANNER SELAMAT DATANG --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm bg-primary text-white" style="background: linear-gradient(45deg, #4e73df, #224abe);">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="fw-bold mb-1">Selamat Datang di SI PANDU, {{ auth()->user()->name ?? 'Admin' }}! 👋</h4>
                    <p class="mb-0 text-white-50">Berikut adalah ringkasan status pemantauan pelatihan hari ini.</p>
                </div>
                <div class="d-none d-md-block text-white-50">
                    <i class="fas fa-chart-line fa-4x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- KARTU STATISTIK --}}
<h5 class="fw-bold text-gray-800 mb-3"><i class="fas fa-chart-pie me-1 text-primary"></i> Ringkasan Data</h5>
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-primary border-4 shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Kelas Kepemimpinan</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ $totalKepemimpinan ?? '0' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users-cog fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-success border-4 shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">Kelas Fungsional</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ $totalFungsional ?? '0' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-warning border-4 shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">Dokumen Pending</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ $totalPending ?? '0' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 border-start border-info border-4 shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">Terkonfirmasi</div>
                        <div class="h3 mb-0 fw-bold text-gray-800">{{ $totalSelesai ?? '0' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SHORTCUT MENU UTAMA --}}
<h5 class="fw-bold text-gray-800 mb-3 mt-2"><i class="fas fa-compass me-1 text-primary"></i> Akses Cepat</h5>
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <a href="{{ route('daftar-pantau.kepemimpinan.index') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 transition-hover">
                <div class="card-body text-center p-5">
                    <div class="mb-3">
                        <i class="fas fa-user-tie fa-4x text-primary"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Daftar Pantau Kepemimpinan</h4>
                    <p class="text-muted mb-0">Kelola dan pantau progres dokumen untuk kelas Kepemimpinan.</p>
                </div>
                <div class="card-footer bg-white border-0 text-center py-3">
                    <span class="btn btn-outline-primary btn-sm rounded-pill px-4">Buka Modul <i class="fas fa-arrow-right ms-1"></i></span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6">
        <a href="{{ route('daftar-pantau.fungsional.index') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 transition-hover">
                <div class="card-body text-center p-5">
                    <div class="mb-3">
                        <i class="fas fa-clipboard-list fa-4x text-success"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Daftar Pantau Fungsional</h4>
                    <p class="text-muted mb-0">Kelola dan pantau progres dokumen untuk kelas Fungsional.</p>
                </div>
                <div class="card-footer bg-white border-0 text-center py-3">
                    <span class="btn btn-outline-success btn-sm rounded-pill px-4">Buka Modul <i class="fas fa-arrow-right ms-1"></i></span>
                </div>
            </div>
        </a>
    </div>
</div>

{{-- ========================================================== --}}
{{-- 2. MODAL POP-UP (DENGAN FITUR RINCIAN COLLAPSE)            --}}
{{-- ========================================================== --}}
<div class="modal fade" id="deadlineModal" tabindex="-1" aria-labelledby="deadlineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="d-none">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center px-4 pb-4">
                <div class="mb-3">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-bell fa-3x text-warning alert-icon-pulse"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-dark mb-2">Perhatian!</h4>
                <p class="text-muted mb-2">
                    Saat ini terdapat <strong>{{ $totalPending ?? 'beberapa' }} dokumen</strong> yang masih berstatus <span class="badge bg-warning text-dark px-2">Pending</span>.
                </p>

                {{-- TOMBOL TOGGLE (BUKA/TUTUP RINCIAN) --}}
                <button class="btn btn-sm btn-outline-secondary rounded-pill mb-3" type="button" data-bs-toggle="collapse" data-toggle="collapse" data-bs-target="#collapseRincian" data-target="#collapseRincian" aria-expanded="false" aria-controls="collapseRincian">
                    Lihat Rincian <i class="fas fa-chevron-down ms-1 toggle-icon"></i>
                </button>

                {{-- AREA RINCIAN (MUNCUL JIKA TOMBOL DIKLIK) --}}
                <div class="collapse text-start mb-4" id="collapseRincian">
                    <div class="card card-body bg-light border-0 p-2 custom-scrollbar" style="max-height: 200px; overflow-y: auto;">
                        <ul class="list-group list-group-flush small">
                            
                            {{-- BLOK DATA DINAMIS (Jika Controller sudah siap mengirim variabel $listPending) --}}
                            @if(isset($listPending) && count($listPending) > 0)
                                @foreach($listPending as $doc)
                                    <li class="list-group-item bg-transparent px-2 py-2 border-bottom">
                                        <div class="fw-bold text-dark">{{ $doc->pelatihan->nama_pelatihan ?? 'Nama Kelas' }}</div>
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <span class="text-muted"><i class="fas fa-file-alt me-1"></i> {{ $doc->jenis_pantau }}</span>
                                            <span class="badge bg-danger text-white rounded-pill shadow-sm">Deadline!</span>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                {{-- BLOK DATA CONTOH (Dummy) AGAR ANDA BISA MELIHAT DESAINNYA SEKARANG --}}
                                <li class="list-group-item bg-transparent px-2 py-2 border-bottom">
                                    <div class="fw-bold text-dark">Pelatihan Kepemimpinan Administrator - Angkatan I</div>
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <span class="text-muted"><i class="fas fa-file-alt me-1 text-primary"></i> SK Kepesertaan</span>
                                        <span class="badge bg-danger text-white rounded-pill shadow-sm"><i class="fas fa-clock me-1"></i> H-2</span>
                                    </div>
                                </li>
                                <li class="list-group-item bg-transparent px-2 py-2 border-bottom">
                                    <div class="fw-bold text-dark">Pelatihan Fungsional Auditor Ahli Muda</div>
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <span class="text-muted"><i class="fas fa-file-alt me-1 text-success"></i> Sertifikat</span>
                                        <span class="badge bg-danger text-white rounded-pill shadow-sm"><i class="fas fa-clock me-1"></i> H-1</span>
                                    </div>
                                </li>
                                <li class="list-group-item bg-transparent px-2 py-2 border-bottom border-0">
                                    <div class="fw-bold text-dark">Pelatihan Kepemimpinan Pengawas - Angkatan II</div>
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <span class="text-muted"><i class="fas fa-file-alt me-1 text-primary"></i> Laporan Akhir</span>
                                        <span class="badge bg-warning text-dark rounded-pill shadow-sm"><i class="fas fa-exclamation-circle me-1"></i> Hari Ini</span>
                                    </div>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-2">
                    <button type="button" class="btn btn-primary rounded-pill py-2 fw-bold shadow-sm" data-bs-dismiss="modal" data-dismiss="modal">
                        Oke, Saya Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    @keyframes pulse-warning {
        0% { transform: scale(1); }
        50% { transform: scale(1.15); }
        100% { transform: scale(1); }
    }
    .alert-icon-pulse {
        animation: pulse-warning 2s infinite;
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1; 
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #c1c1c1; 
        border-radius: 4px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        let totalPending = {{ $totalPending ?? 1 }}; 
        
        // VARIABEL INI KINI MENGAMBIL DATA DARI BACKEND LARAVEL (PHP)
        let isFirstLogin = {{ $showModal ? 'true' : 'false' }};

        // Jika ada pending dan ini adalah akses pertama setelah login
        if(totalPending > 0 && isFirstLogin) {
            if (typeof $.fn.modal !== 'undefined') {
                $('#deadlineModal').modal({ backdrop: 'static', keyboard: false });
                $('#deadlineModal').modal('show');
            } else if (typeof bootstrap !== 'undefined') {
                var deadlineModal = new bootstrap.Modal(document.getElementById('deadlineModal'), { backdrop: 'static', keyboard: false });
                deadlineModal.show();
            }
        }

        // Animasi icon Panah
        $('#collapseRincian').on('show.bs.collapse', function () {
            $('.toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        });
        $('#collapseRincian').on('hide.bs.collapse', function () {
            $('.toggle-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        });
    });
</script>
@endpush

@endsection