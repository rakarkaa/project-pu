@extends('layouts.app')

@section('content')
<div class="mt-4 mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Manajemen Kelas Fungsional</h1>
    <p class="text-muted mt-1">Kelola data master untuk jadwal dan lokasi kelas Fungsional.</p>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-success">
            <i class="fas fa-layer-group me-2"></i>Daftar Kelas Aktif
        </h6>
        
        @if(auth()->user()->isAdmin())
        <a href="{{ route('kelas.fungsional.create') }}" class="btn btn-success btn-sm rounded-pill shadow-sm px-3">
            <i class="fas fa-plus me-1"></i> Tambah Kelas
        </a>
        @endif
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="tableKelasFungsional" class="table table-bordered table-hover align-middle w-100">
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th class="text-start">Nama Pelatihan</th>
                        <th>Balai</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        @if(auth()->user()->isAdmin())
                            <th width="12%">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelas as $item)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-start fw-bold text-dark">{{ $item->pelatihan->nama_pelatihan ?? '-' }}</td>
                        <td><span class="text-secondary"><i class="fas fa-building me-1"></i> {{ $item->balai }}</span></td>
                        <td>
                            <span class="badge bg-light text-dark border px-2 py-1">
                                <i class="fas fa-calendar-alt text-muted me-1"></i> 
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2 py-1">
                                <i class="fas fa-calendar-check text-muted me-1"></i> 
                                {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}
                            </span>
                        </td>

                        @if(auth()->user()->isAdmin())
                        <td>
                            {{-- TOMBOL EDIT --}}
                            <a href="{{ route('kelas.fungsional.edit', $item->id) }}"
                               class="btn btn-sm btn-warning text-white rounded-circle shadow-sm me-1" 
                               title="Edit Kelas">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- TOMBOL DELETE (Sudah dilepas fungsi bawaan browsernya) --}}
                            <form action="{{ route('kelas.fungsional.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                {{-- Perhatikan type="button" agar tidak langsung tersubmit --}}
                                <button type="button" class="btn btn-sm btn-danger rounded-circle shadow-sm btn-delete" title="Hapus Kelas">
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
{{-- Memanggil Library SweetAlert2 secara online --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        // Mengaktifkan DataTables
        $('#tableKelasFungsional').DataTable({
            language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
            ordering: true, 
        });

        // Logika Pop-Up Cantik untuk Tombol Delete
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            let form = $(this).closest('form'); // Mengambil form tempat tombol ini berada
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data kelas ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b', // Warna merah Bootstrap danger
                cancelButtonColor: '#858796', // Warna abu-abu Bootstrap secondary
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true // Membalik posisi tombol agar "Batal" di kiri
            }).then((result) => {
                // Jika user klik "Ya, Hapus!"
                if (result.isConfirmed) {
                    form.submit(); // Baru form benar-benar dikirim ke database
                }
            });
        });
    });
</script>
@endpush