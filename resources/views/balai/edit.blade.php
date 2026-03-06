@extends('layouts.app')

@section('content')

<h1 class="mt-4">Edit Pelatihan</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('pelatihan.index') }}">Master Pelatihan</a></li>
    <li class="breadcrumb-item active">Edit</li>
</ol>

<div class="card">
    <div class="card-header">
        <i class="fas fa-edit"></i> Form Edit Balai
    </div>

    <div class="card-body">
        <form action="{{ route('balai.update', $balai->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Balai</label>
                <input type="text" name="nama_balai"
                       class="form-control"
                       value="{{ $balai->nama_balai }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ $balai->keterangan }}</textarea>
            </div>

            <div class="text-end">
                <a href="{{ route('balai.index') }}" class="btn btn-secondary">
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
