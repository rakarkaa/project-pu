@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Master Pola Penyelenggaraan</h1>
        <p class="text-muted small mb-0">Kelola daftar metode atau pola penyelenggaraan pelatihan.</p>
    </div>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('pola-penyelenggaraan.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
        <i class="fas fa-plus me-1"></i> Tambah Data
    </a>
    @endif
</div>

<div class="card shadow-sm border-0 mb-4 border-start border-primary border-4">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-list me-1"></i> Daftar Pola Penyelenggaraan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tablePola" class="table table-hover align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Nama Penyelenggara / Metode</th>
                        @if(auth()->user()->isAdmin())
                            <th width="12%" class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($pola as $item)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $item->penyelenggara }}</td>
                            @if(auth()->user()->isAdmin())
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pola-penyelenggaraan.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('pola-penyelenggaraan.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#tablePola').DataTable({
            language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
            pageLength: 10,
            responsive: true
        });

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            let form = $(this).closest('form'); 
            
            Swal.fire({
                title: 'Hapus Pola Penyelenggaraan?',
                text: "Data yang dihapus mungkin memengaruhi referensi pada data kelas!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); 
                }
            });
        });
    });
</script>
@endpush