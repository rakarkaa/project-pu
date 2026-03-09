@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mt-4 mb-2">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Monitoring Detail Pemantauan</h1>
        <p class="text-muted mt-1">Pantau progres setiap dokumen/daftar pantau secara spesifik dan real-time.</p>
    </div>
</div>

<div class="card shadow-sm border-0 mb-5">
    <div class="card-header bg-white py-3 border-bottom">
        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-satellite-dish me-2"></i> Status Dokumen Terkini</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tableMonitoring" class="table table-bordered table-hover align-middle w-100" style="font-size: 0.9rem;">
                <thead class="table-light text-center align-middle">
                    <tr>
                        <th width="5%">No</th>
                        <th class="text-start" width="20%">Informasi Kelas</th>
                        {{-- TAMBAHAN KOLOM BARU UNTUK JADWAL --}}
                        <th width="15%">Jadwal Pelaksanaan</th>
                        <th width="15%">Rincian Dokumen</th>
                        <th><i class="fas fa-file-signature text-secondary d-block mb-1"></i> Penyusunan</th>
                        <th><i class="fas fa-pen-nib text-secondary d-block mb-1"></i> Proses TTD</th>
                        <th><i class="fas fa-paper-plane text-secondary d-block mb-1"></i> Terkirim</th>
                        <th><i class="fas fa-check-double text-secondary d-block mb-1"></i> Konfirmasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($semuaPemantauan as $i => $item)
                    <tr class="text-center">
                        <td>{{ $i+1 }}</td>
                        
                        {{-- INFORMASI KELAS (Nama & Badge saja) --}}
                        <td class="text-start">
                            <span class="fw-bold text-dark d-block mb-2">{{ $item->nama_pelatihan }}</span>
                            @if($item->jenis_kelas == 'Kepemimpinan')
                                <span class="badge bg-primary px-2 py-1 shadow-sm"><i class="fas fa-user-tie"></i> Kepemimpinan</span>
                            @else
                                <span class="badge bg-success px-2 py-1 shadow-sm"><i class="fas fa-clipboard-list"></i> Fungsional</span>
                            @endif
                        </td>

                        {{-- KOLOM BARU: JADWAL MULAI & SELESAI --}}
                        <td class="text-start">
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-calendar-alt me-1 text-primary"></i> Mulai: <br> 
                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}</span>
                            </small>
                            <small class="text-muted d-block">
                                <i class="fas fa-calendar-check me-1 text-danger"></i> Selesai: <br> 
                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}</span>
                            </small>
                        </td>

                        {{-- RINCIAN DOKUMEN --}}
                        <td class="text-start">
                            <span class="fw-bold text-secondary d-block">{{ $item->jenis_pantau }}</span>
                            <small class="text-muted">Tujuan: {{ $item->tujuan }}</small>
                        </td>

                        {{-- INDIKATOR PROGRES TRACKER --}}
                        <td>
                            @if($item->progress_level >= 1) 
                                <i class="fas fa-check-circle text-success fs-5"></i> 
                            @else 
                                <i class="fas fa-circle text-light fs-5 border rounded-circle shadow-sm"></i> 
                            @endif
                        </td>
                        <td>
                            @if($item->progress_level >= 2) 
                                <i class="fas fa-check-circle text-success fs-5"></i> 
                            @else 
                                <i class="fas fa-circle text-light fs-5 border rounded-circle shadow-sm"></i> 
                            @endif
                        </td>
                        <td>
                            @if($item->progress_level >= 3) 
                                <i class="fas fa-check-circle text-success fs-5"></i> 
                            @else 
                                <i class="fas fa-circle text-light fs-5 border rounded-circle shadow-sm"></i> 
                            @endif
                        </td>
                        <td>
                            @if($item->progress_level >= 4) 
                                <i class="fas fa-check-circle text-success fs-5"></i> 
                            @else 
                                <i class="fas fa-circle text-light fs-5 border rounded-circle shadow-sm"></i> 
                            @endif
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
    $(document).ready(function() {
        $('#tableMonitoring').DataTable({
            language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
            ordering: true, 
            pageLength: 10
        });
    });
</script>
@endpush
@endsection