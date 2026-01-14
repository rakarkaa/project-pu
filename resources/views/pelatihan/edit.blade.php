@extends('layouts.app')

@section('content')

<h1 class="mt-4">Edit Pelatihan</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('pelatihan.index') }}">Master Pelatihan</a></li>
    <li class="breadcrumb-item active">Edit</li>
</ol>

<div class="card">
    <div class="card-header">
        <i class="fas fa-edit"></i> Form Edit Pelatihan
    </div>

    <div class="card-body">
        <form action="{{ route('pelatihan.update', $pelatihan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Pelatihan</label>
                <input type="text" name="nama_pelatihan"
                       class="form-control"
                       value="{{ $pelatihan->nama_pelatihan }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Pelatihan</label>
                <select name="jenis_pelatihan" class="form-select">
                    <option value="kepemimpinan"
                        {{ $pelatihan->jenis_pelatihan == 'kepemimpinan' ? 'selected' : '' }}>
                        Kepemimpinan
                    </option>
                    <option value="fungsional"
                        {{ $pelatihan->jenis_pelatihan == 'fungsional' ? 'selected' : '' }}>
                        Fungsional
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tahun</label>
                <input type="number" name="tahun"
                       class="form-control"
                       value="{{ $pelatihan->tahun }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ $pelatihan->keterangan }}</textarea>
            </div>

            <div class="text-end">
                <a href="{{ route('pelatihan.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button class="btn btn-primary">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
