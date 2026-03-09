@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mt-4 mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Dashboard Terpadu</h1>
    <span class="text-muted"><i class="fas fa-clock me-1"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
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

{{-- KARTU STATISTIK (ANGKA DUMMY SEMENTARA) --}}
<h5 class="fw-bold text-gray-800 mb-3"><i class="fas fa-chart-pie me-1 text-primary"></i> Ringkasan Data</h5>
<div class="row g-4 mb-4">
    {{-- Card 1: Total Kelas Kepemimpinan --}}
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

    {{-- Card 2: Total Kelas Fungsional --}}
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

    {{-- Card 3: Status Pending --}}
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

    {{-- Card 4: Selesai / Terkonfirmasi --}}
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

@push('styles')
<style>
    /* Efek hover untuk card akses cepat agar terlihat interaktif */
    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush

@endsection