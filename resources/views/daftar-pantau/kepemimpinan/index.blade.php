@extends('layouts.app')

@section('content')
<h1 class="mt-4">Daftar Pantau Kepemimpinan</h1>

<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="tablePantauKepemimpinan"
                   class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelatihan</th>
                        <th>Balai</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->pelatihan->nama_pelatihan }}</td>
                            <td>{{ $item->balai }}</td>
                            <td>{{ $item->tanggal_mulai }}</td>
                            <td>{{ $item->tanggal_selesai }}</td>
                            <td>
                                <a href="{{ route('daftar-pantau.kepemimpinan.show', $item->id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </td>
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
$(function () {
    $('#tablePantauKepemimpinan').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        }
    });
});
</script>
@endpush
