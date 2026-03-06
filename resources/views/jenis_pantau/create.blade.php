@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Jenis Pantau</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('jenis-pantau.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Pantau</label>
                    <input type="text" name="nama_pantau" class="form-control" required placeholder="Masukkan Nama Pantau">
                </div>

                <button class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('jenis-pantau.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection