@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('pola-penyelenggaraan.index') }}" class="btn btn-link text-decoration-none p-0 me-3 text-primary">
                <i class="fas fa-arrow-left fa-lg"></i>
            </a>
            <h1 class="h3 mb-0 text-gray-800">Tambah Pola Penyelenggaraan</h1>
        </div>

        <div class="card shadow-sm border-0 border-top border-primary border-4">
            <div class="card-body p-4">
                <form action="{{ route('pola-penyelenggaraan.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Penyelenggara</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-layer-group text-muted"></i></span>
                            <input type="text" name="penyelenggara" class="form-control" 
                                   required placeholder="Contoh: Klasikal, Blended, dll" value="{{ old('penyelenggara') }}">
                        </div>
                        <small class="text-muted">Gunakan nama yang jelas untuk membedakan metode pelatihan.</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2 shadow-sm">
                            <i class="fas fa-save me-1"></i> Simpan Pola
                        </button>
                        <a href="{{ route('pola-penyelenggaraan.index') }}" class="btn btn-light py-2 border">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection