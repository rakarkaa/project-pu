@extends('layouts.app')

@section('content')
<h1 class="mt-4">Daftar Pantau Kepemimpinan</h1>

{{-- CARD INFO KELAS --}}
<div class="row justify-content-center mb-4">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="fw-bold">
                    {{ $kelas->pelatihan->nama_pelatihan }}
                </h5>
                <p class="mb-1">Balai: {{ $kelas->balai }}</p>
                <p class="mb-0">
                    {{ $kelas->tanggal_mulai }} s/d {{ $kelas->tanggal_selesai }}
                </p>
            </div>
        </div>
    </div>
</div>

{{-- BUTTON TAMBAH --}}
<div class="mb-4 text-end">
    <button id="btnTambahPantau" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Daftar Pantau
    </button>
        <div id="formDaftarPantau" class="card mb-4 d-none">
        <div class="card-body">

            {{-- TABS FORM --}}
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active"
                            data-bs-toggle="tab"
                            data-bs-target="#form-kepesertaan">
                        Kepesertaan
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#form-pengajar">
                        Pengajar
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#form-manajemen">
                        Manajemen
                    </button>
                </li>
            </ul>

            {{-- TAB CONTENT --}}
            <div class="tab-content">
                <div class="tab-pane fade show active" id="form-kepesertaan">
                    @include('daftar-pantau.kepemimpinan.tabs.kepesertaan')
                </div>

                <div class="tab-pane fade" id="form-pengajar">
                    @include('daftar-pantau.kepemimpinan.tabs.pengajar')
                </div>

                <div class="tab-pane fade" id="form-manajemen">
                    @include('daftar-pantau.kepemimpinan.tabs.manajemen')
                </div>
            </div>

        </div>
    </div>

</div>

{{-- DATA KEPESERTAAN --}}
<hr>
<h5 class="mt-4">Data Kepesertaan</h5>

<div class="table-responsive">
    <table id="tableKepesertaan"
           class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Total Peserta</th>
                <th>Jenis Pantau</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Tujuan</th>
                <th>Lampiran</th>

                @if(auth()->user()->isAdmin())
                    <th width="10%">Aksi</th>
                @endif
            </tr>
        </thead>
            <tbody>
            @forelse($kepesertaan as $item)
            @php
                $today = \Carbon\Carbon::now();
                $tanggalMulai = \Carbon\Carbon::parse($kelas->tanggal_mulai);
                $tanggalSelesai = \Carbon\Carbon::parse($kelas->tanggal_selesai);
                
                if ($today->gt($tanggalMulai)) {
                    $deadline = '-';
                    $status = 'Melebihi Deadline';
                    $badgeClass = 'bg-danger';
                } else {
                    $diffDays = intval($today->diffInDays($tanggalMulai));
                    $deadline = 'H-' . $diffDays;
                    $status = $item->status_pantau;
                    $badgeClass = 'bg-info';
                }
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->total_peserta }}</td>
                <td>{{ $item->jenis_pantau }}</td>
                <td>{{ $deadline }}</td>
                <td>
                    <span class="badge {{ $badgeClass }}">
                        {{ $status }}
                    </span>
                </td>
                <td>{{ $item->tujuan }}</td>
                <td>
                    @if($item->lampiran)
                        <a href="{{ asset('storage/'.$item->lampiran) }}" target="_blank">
                            Lihat
                        </a>
                    @else
                        -
                    @endif
                </td>

                @if(auth()->user()->isAdmin())
                <td>
                    <form action="{{ route('pantau.kepesertaan.destroy', $item->id) }}"
                        method="POST"
                        onsubmit="return confirm('Hapus data ini?')">
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
                <td colspan="8" class="text-center text-muted">
                    Belum ada data kepesertaan
                </td>
            </tr>
            @endforelse
            </tbody>
    </table>
</div>

{{-- DATA PENGAJAR --}}
<hr>
<h5 class="mt-4">Data Pengajar</h5>

<div class="table-responsive">
    <table id="tablePengajar"
           class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Daftar Pengajar</th>
                <th>Jenis Pantau</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Tujuan</th>
                <th>Lampiran</th>

                @if(auth()->user()->isAdmin())
                    <th width="10%">Aksi</th>
                @endif
            </tr>
        </thead>
            <tbody>
            @forelse($pengajar as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->daftar_pengajar }}</td>
                <td>{{ $item->jenis_pantau }}</td>
                <td>{{ $item->deadline_pantau }}</td>
                <td>
                    <span class="badge bg-info">
                        {{ $item->status_pantau }}
                    </span>
                </td>
                <td>{{ $item->tujuan }}</td>
                <td>
                    @if($item->lampiran)
                        <a href="{{ asset('storage/'.$item->lampiran) }}" target="_blank">
                            Lihat
                        </a>
                    @else
                        -
                    @endif
                </td>

                @if(auth()->user()->isAdmin())
                <td>
                    <form action="{{ route('pantau.pengajar.destroy', $item->id) }}"
                        method="POST"
                        onsubmit="return confirm('Hapus data ini?')">
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
                <td colspan="8" class="text-center text-muted">
                    Belum ada data Pengajar
                </td>
            </tr>
            @endforelse
            </tbody>
    </table>
</div>

{{-- DATA MANAJEMEN --}}
<hr>
<h5 class="mt-4">Data Manajemen</h5>

<div class="table-responsive">
    <table id="tableManajemen"
           class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Perihal Manajemen</th>
                <th>Jenis Pantau</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Tujuan</th>
                <th>Lampiran</th>

                @if(auth()->user()->isAdmin())
                    <th width="10%">Aksi</th>
                @endif
            </tr>
        </thead>
            <tbody>
            @forelse($manajemen as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->perihal_manajemen }}</td>
                <td>{{ $item->jenis_pantau }}</td>
                <td>{{ $item->deadline_pantau }}</td>
                <td>
                    <span class="badge bg-info">
                        {{ $item->status_pantau }}
                    </span>
                </td>
                <td>{{ $item->tujuan }}</td>
                <td>
                    @if($item->lampiran)
                        <a href="{{ asset('storage/'.$item->lampiran) }}" target="_blank">
                            Lihat
                        </a>
                    @else
                        -
                    @endif
                </td>

                @if(auth()->user()->isAdmin())
                <td>
                    <form action="{{ route('pantau.manajemen.destroy', $item->id) }}"
                        method="POST"
                        onsubmit="return confirm('Hapus data ini?')">
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
                <td colspan="8" class="text-center text-muted">
                    Belum ada data Manajemen
                </td>
            </tr>
            @endforelse
            </tbody>
    </table>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    $('#tableKepesertaan').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        }
    });
});
</script>
@endpush

@push('scripts')
<script>
$(document).ready(function () {
    $('#tablePengajar').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        }
    });
});
</script>
@endpush

@push('scripts')
<script>
$(document).ready(function () {
    $('#tableManajemen').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        }
    });
});
</script>
@endpush

@push('scripts')
<script>
    document.getElementById('btnTambahPantau').addEventListener('click', function () {
        document.getElementById('formDaftarPantau').classList.toggle('d-none');
    });
</script>
@endpush




@endsection
