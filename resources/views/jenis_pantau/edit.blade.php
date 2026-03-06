@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Jenis Pantau</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('jenis-pantau.update', $jenisPantau->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Nama Pantau</label>
                    <input type="text" name="nama_pantau" class="form-control" value="{{ $jenisPantau->nama_pantau }}" required>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('jenis-pantau.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection