@extends('layouts.app')

@section('content')
<div class="mt-4 mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Kelas Fungsional</h1>
    <p class="text-muted mt-1">Perbarui data kelas dan jadwal pelaksanaan.</p>
</div>

{{-- PENANGKAP PESAN ERROR --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <strong>Gagal Disimpan!</strong> Silakan periksa isian form Anda:
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 border-bottom">
        <h6 class="mb-0 fw-bold text-success"><i class="fas fa-edit me-2"></i>Form Edit Kelas</h6>
    </div>
    
    <div class="card-body p-4">
        <form action="{{ route('kelas.fungsional.update', $kelas->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Pelatihan</label>
                <select name="pelatihan_id" class="form-select" required>
                    <option value="">-- Pilih Pelatihan --</option>
                    @foreach($pelatihan as $p)
                        <option value="{{ $p->id }}" {{ $kelas->pelatihan_id == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_pelatihan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Input Angkatan --}}
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Angkatan</label>
                <input type="text" name="angkatan" class="form-control" value="{{ $kelas->angkatan }}" placeholder="Contoh: Angkatan I" required>
            </div>

            {{-- Dropdown Select balai_id yang sudah diperbaiki --}}
            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Balai</label>
                <select name="balai_id" class="form-select" required>
                    <option value="">-- Pilih Balai --</option>
                    @foreach($balai as $item)
                        <option value="{{ $item->id }}" {{ $kelas->balai == $item->nama_balai ? 'selected' : '' }}>
                            {{ $item->nama_balai }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold text-dark">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $kelas->tanggal_mulai }}" required>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold text-dark">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ $kelas->tanggal_selesai }}" required>
                </div>
            </div>

            <hr class="mb-4">

            <div class="d-flex">
                <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                    <i class="fas fa-save me-1"></i> Update Data
                </button>
                <a href="{{ route('kelas.fungsional.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection