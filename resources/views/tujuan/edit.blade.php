@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h1 class="h3 mb-0 text-gray-800">Edit Tujuan Surat</h1>
    <a href="{{ route('tujuan-surat.index') }}" class="btn btn-secondary btn-sm shadow-sm rounded-pill px-3">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card shadow-sm border-0 border-top border-primary border-4 mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-edit me-1"></i> Form Edit Data</h6>
    </div>
    <div class="card-body p-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tujuan-surat.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Unit Organisasi <span class="text-danger">*</span></label>
                    <input type="text" name="nama_unitorganisasi" class="form-control" value="{{ $item->nama_unitorganisasi }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Unit Kerja <span class="text-danger">*</span></label>
                    <input type="text" name="nama_unitkerja" class="form-control" value="{{ $item->nama_unitkerja }}" required>
                </div>
            </div>

            <hr class="mt-4">
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4 shadow-sm rounded-pill">
                    <i class="fas fa-save me-1"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection