@extends('layouts.app')

@section('content')
<h1 class="mt-4">Edit Kelas Kepemimpinan</h1>

<div class="card">
    <div class="card-body">

        <form action="{{ route('kelas.kepemimpinan.update', $kelas->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Pelatihan</label>
                <select name="pelatihan_id" class="form-select" required>
                    @foreach($pelatihan as $p)
                        <option value="{{ $p->id }}"
                            {{ $kelas->pelatihan_id == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_pelatihan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Balai</label>
                <input type="text" name="balai"
                       class="form-control"
                       value="{{ $kelas->balai }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai"
                           class="form-control"
                           value="{{ $kelas->tanggal_mulai }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai"
                           class="form-control"
                           value="{{ $kelas->tanggal_selesai }}" required>
                </div>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('kelas.kepemimpinan.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>

    </div>
</div>
@endsection
