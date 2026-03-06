@extends('layouts.app')

@section('content')

<h1 class="mt-4">Master Balai</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Master Balai</li>
</ol>

{{-- ========================= --}}
{{-- CARD 1 : TABEL CRUD --}}
{{-- ========================= --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Master Balai
        </div>

    @if(auth()->user()->isAdmin())
    <div class="d-flex justify-content-start mt-3 px-3">
        <a href="{{ route('balai.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Balai
        </a>
    </div>
    @endif


    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="tableBalai" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Balai</th>
                        <th>Keterangan</th>
                        @if(auth()->user()->isAdmin())
                        <th width="15%" class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($balai as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_balai }}</td>
                            <td>{{ $item->keterangan }}</td>
                            @if(auth()->user()->isAdmin())
                            <td class="text-center">
                                <a href="{{ route('balai.edit', $item->id) }}"
                                class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('balai.destroy', $item->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            @endif

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Data balai belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ========================= --}}
{{-- CARD 2 : TABEL INFORMATIF --}}
{{-- ========================= --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <i class="fas fa-info-circle me-1"></i>
        Ringkasan Informasi Balai
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-borderless">
                <thead>
                    <tr class="text-muted">
                        <th>Balai</th>
                        <th>Keterangan</th>
                        <th>Status Umum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($balai as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->nama_balai }}</strong><br>
                            </td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                <span class="badge bg-success">
                                    Terdata
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#tableBalai').DataTable({
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50, 100],
            ordering: true,
            searching: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });
</script>
@endpush


@endsection
