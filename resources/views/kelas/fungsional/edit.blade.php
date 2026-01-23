@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Kelas Fungsional</h1>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('kelas.fungsional.update', $kelas->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Jenis Pelatihan</label>
                    <select name="pelatihan_id" class="form-control" required>
                        @foreach($pelatihan as $p)
                            <option value="{{ $p->id }}"
                                {{ $kelas->pelatihan_id == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_pelatihan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Balai</label>
                    <input type="text" name="balai"
                        class="form-control"
                        value="{{ $kelas->balai }}" required>
                </div>

                <div class="mb-3">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai"
                        class="form-control"
                        value="{{ $kelas->tanggal_mulai }}" required>
                </div>

                <div class="mb-3">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai"
                        class="form-control"
                        value="{{ $kelas->tanggal_selesai }}" required>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('kelas.fungsional.index') }}"
                   class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>
@endsection
