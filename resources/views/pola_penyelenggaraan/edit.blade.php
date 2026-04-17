@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('pola-penyelenggaraan.index') }}" class="btn btn-link text-decoration-none p-0 me-3 text-warning">
                <i class="fas fa-arrow-left fa-lg"></i>
            </a>
            <h1 class="h3 mb-0 text-gray-800">Edit Pola Penyelenggaraan</h1>
        </div>

        <div class="card shadow-sm border-0 border-top border-warning border-4">
            <div class="card-body p-4">
                <form action="{{ route('pola-penyelenggaraan.update', $pola->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-warning">Nama Penyelenggara</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-edit text-muted"></i></span>
                            <input type="text" name="penyelenggara" class="form-control" value="{{ $pola->penyelenggara }}" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning text-white py-2 shadow-sm">
                            <i class="fas fa-sync-alt me-1"></i> Perbarui Data
                        </button>
                        <a href="{{ route('pola-penyelenggaraan.index') }}" class="btn btn-light py-2 border">Batal</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center mt-3">
            <small class="text-muted">ID Record: #{{ $pola->id }} | Terakhir diperbarui: {{ $pola->updated_at->format('d/m/Y H:i') }}</small>
        </div>
    </div>
</div>
@endsection