@extends('layouts.app')

@section('content')
<h1 class="mt-4">Tambah Kelas Kepemimpinan</h1>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-plus me-1"></i>
        Form Tambah Kelas
    </div>

    <div class="card-body">
        <form action="{{ route('kelas.kepemimpinan.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Pelatihan</label>
                <select name="pelatihan_id"
                        class="form-select"
                        required>
                    <option value="">-- Pilih Pelatihan --</option>
                    @foreach($pelatihan as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama_pelatihan }} ({{ $item->tahun }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Balai</label>
                <input type="text"
                       name="balai"
                       class="form-control"
                       required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date"
                           name="tanggal_mulai"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date"
                           name="tanggal_selesai"
                           class="form-control"
                           required>
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-save"></i> Simpan
                </button>

                <a href="{{ route('kelas.kepemimpinan.index') }}"
                   class="btn btn-secondary btn-sm">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
