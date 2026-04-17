@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('pic.index') }}" class="btn btn-link text-decoration-none p-0 me-3">
                <i class="fas fa-arrow-left fa-lg"></i>
            </a>
            <h1 class="h3 mb-0 text-gray-800">Tambah Data PIC</h1>
        </div>

        <div class="card shadow-sm border-0 border-top border-primary border-4">
            <div class="card-body p-4">
                <form action="{{ route('pic.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama PIC</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                   required placeholder="Masukkan Nama Lengkap" value="{{ old('nama') }}">
                        </div>
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Bagian / Unit Kerja</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-briefcase text-muted"></i></span>
                            <input type="text" name="bagian" class="form-control @error('bagian') is-invalid @enderror" 
                                   required placeholder="Contoh: Administrasi, Keuangan, dll" value="{{ old('bagian') }}">
                        </div>
                        @error('bagian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2 shadow-sm">
                            <i class="fas fa-save me-1"></i> Simpan Data PIC
                        </button>
                        <a href="{{ route('pic.index') }}" class="btn btn-light py-2 border">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection