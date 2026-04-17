@extends('layouts.app')

@section('content')
<h1 class="mt-4">Tambah Kelas Fungsional</h1>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="{{ route('kelas.fungsional.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Pelatihan</label>
                    <select name="pelatihan_id" class="form-select @error('pelatihan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pelatihan --</option>
                        @foreach($pelatihan as $p)
                            <option value="{{ $p->id }}" {{ old('pelatihan_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_pelatihan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Angkatan</label>
                    <input type="text" name="angkatan" class="form-control" placeholder="Contoh: I, 2, dll" value="{{ old('angkatan') }}" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Total Peserta</label>
                    <input type="number" name="total_peserta" class="form-control" value="{{ old('total_peserta') }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Balai</label>
                    <select name="balai_id" class="form-select" required>
                        <option value="">-- Pilih Balai --</option>
                        @foreach($balai as $item)
                            <option value="{{ $item->id }}" {{ old('balai_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_balai }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Pola Penyelenggaraan</label>
                    <select name="pola_penyelenggaraan" class="form-select @error('pola_penyelenggaraan') is-invalid @enderror" required>
                        <option value="">-- Pilih Pola --</option>
                        @foreach($pola as $p)
                            <option value="{{ $p->penyelenggara }}" {{ old('pola_penyelenggaraan') == $p->penyelenggara ? 'selected' : '' }}>
                                {{ $p->penyelenggara }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}" required>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success px-4"><i class="fas fa-save me-1"></i> Simpan</button>
                <a href="{{ route('kelas.fungsional.index') }}" class="btn btn-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection