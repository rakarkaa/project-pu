@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Master Data PIC</h1>
        <p class="text-muted small mb-0">Kelola daftar Person In Charge (PIC) untuk pemantauan dokumen.</p>
    </div>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('pic.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
        <i class="fas fa-plus me-1"></i> Tambah PIC
    </a>
    @endif
</div>

<div class="card shadow-sm border-0 mb-4 border-start border-primary border-4">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-users me-1"></i> Daftar Person In Charge</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tablePic" class="table table-hover align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama Lengkap</th>
                        <th>Bagian / Unit Kerja</th>
                        @if(auth()->user()->isAdmin())
                            <th width="12%" class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($pic as $item)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $item->nama }}</td>
                            <td><span class="badge bg-light text-primary border border-primary px-3 py-2" style="font-size: 0.85rem;">{{ $item->bagian }}</span></td>
                            @if(auth()->user()->isAdmin())
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pic.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    {{-- Hapus onsubmit bawaan, ganti dengan class form-delete dan btn-delete --}}
                                    <form action="{{ route('pic.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" title="Hapus Data">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
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
{{-- Tambahkan CDN SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTable
        $('#tablePic').DataTable({
            language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
            pageLength: 10,
            responsive: true
        });

        // Konfigurasi SweetAlert2 untuk tombol hapus
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            let form = $(this).closest('form'); 
            
            Swal.fire({
                title: 'Hapus Data PIC?',
                text: "PIC yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545', // Warna merah bahaya
                cancelButtonColor: '#6c757d', // Warna abu-abu netral
                confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true // Membalik posisi tombol agar "Batal" ada di kiri
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); 
                }
            });
        });
    });
</script>
@endpush