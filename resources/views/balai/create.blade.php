@extends('layouts.app')

@section('content')

<h1 class="mt-4">Tambah Balai</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('balai.index') }}">Master Balai</a></li>
    <li class="breadcrumb-item active">Tambah</li>
</ol>

<div class="card">
    <div class="card-header">
        <i class="fas fa-plus"></i> Form Tambah Balai
    </div>

    <div class="card-body">
        <form action="{{ route('balai.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Balai</label>
                <input type="text" name="nama_balai"
                       class="form-control @error('nama_balai') is-invalid @enderror"
                       value="{{ old('nama_balai') }}">
                @error('nama_balai')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan (Opsional)</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>

            <div class="text-end">
                <a href="{{ route('balai.index') }}" class="btn btn-secondary">
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
