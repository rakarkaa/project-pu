@extends('layouts.app')

@section('content')
<h1 class="mt-4">Master Jenis Pantau</h1>

<div class="card mb-4 shadow">
    <div class="card-header">
        <i class="fas fa-list me-1"></i>
        Data Master Jenis Pantau
    </div>

    @if(auth()->user()->isAdmin())
    <div class="d-flex justify-content-start mt-3 px-3">
        <a href="{{ route('jenis-pantau.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Data
        </a>
    </div>
    @endif

    <div class="card-body">
        <div class="table-responsive">
            <table id="tableJenisPantau" class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Pantau</th>
                        @if(auth()->user()->isAdmin())
                            <th width="15%">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($jenisPantau as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_pantau }}</td>
                            @if(auth()->user()->isAdmin())
                            <td>
                                <a href="{{ route('jenis-pantau.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('jenis-pantau.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
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
        $('#tableJenisPantau').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
            }
        });
    });
</script>
@endpush