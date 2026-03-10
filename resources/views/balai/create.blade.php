@extends('layouts.app')

@section('content')
<div class="mt-4 mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Tambah Master Balai</h1>
    <p class="text-muted mt-1">Tambahkan data referensi balai pelatihan baru ke dalam sistem.</p>
</div>

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
        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-plus-circle me-2"></i>Form Tambah Balai</h6>
    </div>

    <div class="card-body p-4">
        <form action="{{ route('balai.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Nama Balai <span class="text-danger">*</span></label>
                <input type="text" name="nama_balai"
                       class="form-control @error('nama_balai') is-invalid @enderror"
                       value="{{ old('nama_balai') }}" placeholder="Masukkan nama balai..." required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Keterangan <span class="text-muted fw-normal">(Opsional)</span></label>
                <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan catatan atau alamat jika diperlukan...">{{ old('keterangan') }}</textarea>
            </div>

            <hr class="mb-4">

            <div class="d-flex">
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-save me-1"></i> Simpan Data
                </button>
                <a href="{{ route('balai.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection