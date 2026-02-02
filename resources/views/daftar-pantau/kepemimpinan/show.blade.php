@extends('layouts.app')

@section('content')
<h1 class="mt-4">Daftar Pantau Kepemimpinan</h1>

{{-- CARD INFO KELAS --}}
<div class="row justify-content-center mb-4">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="fw-bold">
                    {{ $kelas->pelatihan->nama_pelatihan }}
                </h5>
                <p class="mb-1">Balai: {{ $kelas->balai }}</p>
                <p class="mb-0">
                    {{ $kelas->tanggal_mulai }} s/d {{ $kelas->tanggal_selesai }}
                </p>
            </div>
        </div>
    </div>
</div>

{{-- BUTTON TAMBAH --}}
<div class="mb-4 text-end">
    <button class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Daftar Pantau
    </button>
</div>

{{-- DATA KEPESERTAAN --}}
<div class="card mb-4">
    <div class="card-header fw-bold">Daftar Pantau Kepesertaan</div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <td class="text-center text-muted">
                    Belum ada data
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- DATA PENGAJAR --}}
<div class="card mb-4">
    <div class="card-header fw-bold">Daftar Pantau Pengajar</div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <td class="text-center text-muted">
                    Belum ada data
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- DATA MANAJEMEN --}}
<div class="card mb-4">
    <div class="card-header fw-bold">Daftar Pantau Manajemen</div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <td class="text-center text-muted">
                    Belum ada data
                </td>
            </tr>
        </table>
    </div>
</div>

@endsection
