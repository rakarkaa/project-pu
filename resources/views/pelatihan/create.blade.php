@extends('layouts.app')

@section('content')

<h1 class="mt-4">Tambah Pelatihan</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('pelatihan.index') }}">Master Pelatihan</a></li>
    <li class="breadcrumb-item active">Tambah</li>
</ol>

<div class="card">
    <div class="card-header">
        <i class="fas fa-plus"></i> Form Tambah Pelatihan
    </div>

    <div class="card-body">
        <form action="{{ route('pelatihan.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Pelatihan</label>
                <input type="text" name="nama_pelatihan"
                       class="form-control @error('nama_pelatihan') is-invalid @enderror"
                       value="{{ old('nama_pelatihan') }}">
                @error('nama_pelatihan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Pelatihan</label>
                <select name="jenis_pelatihan"
                        class="form-select @error('jenis_pelatihan') is-invalid @enderror">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="kepemimpinan">Kepemimpinan</option>
                    <option value="fungsional">Fungsional</option>
                </select>
                @error('jenis_pelatihan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Tahun</label>
                <input type="number" name="tahun"
                       class="form-control @error('tahun') is-invalid @enderror"
                       value="{{ old('tahun') }}"
                       placeholder="Contoh: 2026">
                @error('tahun')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan (Opsional)</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>

            <div class="text-end">
                <a href="{{ route('pelatihan.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button class="btn btn-primary">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
