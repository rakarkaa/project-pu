@extends('layouts.app')

@section('content')
<h1 class="mt-4">Kelas Fungsional</h1>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-layer-group me-1"></i>
        Data Kelas Fungsional
    </div>

    {{-- TOMBOL TAMBAH (ADMIN ONLY) --}}
    @if(auth()->user()->isAdmin())
    <div class="d-flex justify-content-start mt-3 px-3">
        <a href="{{ route('kelas.fungsional.create') }}"
           class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Kelas
        </a>
    </div>
    @endif

    <div class="card-body">
        <div class="table-responsive">
            <table id="tableKelasFungsional"
                   class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelatihan</th>
                        <th>Balai</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>

                        {{-- KOLOM AKSI HANYA UNTUK ADMIN --}}
                        @if(auth()->user()->isAdmin())
                            <th width="15%">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @forelse($kelas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->pelatihan->nama_pelatihan }}</td>
                            <td>{{ $item->balai }}</td>
                            <td>{{ $item->tanggal_mulai }}</td>
                            <td>{{ $item->tanggal_selesai }}</td>

                            {{-- KOLOM AKSI (ADMIN ONLY) --}}
                            @if(auth()->user()->isAdmin())
                            <td>
                                <a href="{{ route('kelas.fungsional.edit', $item->id) }}"
                                class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('kelas.fungsional.destroy', $item->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin hapus data?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#tableKelasFungsional').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
            }
        });
    });
</script>
@endpush
