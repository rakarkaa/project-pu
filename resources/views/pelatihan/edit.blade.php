@extends('layouts.app')

@section('content')
<div class="mt-4 mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Master Pelatihan</h1>
    <p class="text-muted mt-1">Perbarui rincian referensi data pelatihan.</p>
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
        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-edit me-2"></i>Form Edit Pelatihan</h6>
    </div>

    <div class="card-body p-4">
        <form action="{{ route('pelatihan.update', $pelatihan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Nama Pelatihan <span class="text-danger">*</span></label>
                <input type="text" name="nama_pelatihan"
                       class="form-control"
                       value="{{ $pelatihan->nama_pelatihan }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold text-dark">Jenis Pelatihan <span class="text-danger">*</span></label>
                    <select name="jenis_pelatihan" class="form-select" required>
                        <option value="kepemimpinan" {{ $pelatihan->jenis_pelatihan == 'kepemimpinan' ? 'selected' : '' }}>
                            Kepemimpinan
                        </option>
                        <option value="fungsional" {{ $pelatihan->jenis_pelatihan == 'fungsional' ? 'selected' : '' }}>
                            Fungsional
                        </option>
                    </select>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold text-dark">Tahun <span class="text-danger">*</span></label>
                    <input type="number" name="tahun"
                           class="form-control"
                           value="{{ $pelatihan->tahun }}" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark">Keterangan <span class="text-muted fw-normal">(Opsional)</span></label>
                <textarea name="keterangan" class="form-control" rows="3">{{ $pelatihan->keterangan }}</textarea>
            </div>

            <hr class="mb-4">

            <div class="d-flex">
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-save me-1"></i> Update Data
                </button>
                <a href="{{ route('pelatihan.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm ms-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection