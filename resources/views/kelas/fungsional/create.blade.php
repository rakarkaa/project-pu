@extends('layouts.app')

@section('content')
<h1 class="mt-4">Tambah Kelas Fungsional</h1>

<div class="card">
    <div class="card-body">

        <form action="{{ route('kelas.fungsional.store') }}" method="POST">
            @csrf

            {{-- Pelatihan --}}
            <div class="mb-3">
                <label class="form-label">Pelatihan</label>
                <select name="pelatihan_id" class="form-select" required>
                    <option value="">-- Pilih Pelatihan --</option>
                    @foreach($pelatihan as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->nama_pelatihan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Balai --}}
            <div class="mb-3">
                <label class="form-label">Balai</label>
                <input type="text"
                       name="balai"
                       class="form-control"
                       placeholder="Contoh: BPSDMD Provinsi"
                       required>
            </div>

            {{-- Tanggal --}}
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

            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>

            <a href="{{ route('kelas.fungsional.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>
@endsection
