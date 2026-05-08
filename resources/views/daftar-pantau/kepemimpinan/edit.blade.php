@extends('layouts.app')

@section('content')
{{-- 1. HEADER HALAMAN --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-4 mb-3 gap-2">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Pemantauan Kepemimpinan</h1>
        <p class="text-muted mt-1">Perbarui data dokumen pemantauan untuk kelas kepemimpinan ini.</p>
    </div>
    <a href="{{ route('daftar-pantau.kepemimpinan.show', $item->kelas_kepemimpinan_id) }}" class="btn btn-secondary shadow-sm rounded-pill px-3">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card shadow-sm border-0 border-top border-primary border-4 mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-edit me-1"></i> Form Edit Data Pemantauan</h6>
    </div>
    <div class="card-body p-4">
        
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('pantau.kepesertaan.update', $item->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                {{-- 1. JENIS PANTAU --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Jenis Pantau</label>
                    <select name="jenis_pantau" class="form-select border-primary" required>
                        <option value="">-- Pilih --</option>
                        @foreach($jenisPantau as $jp)
                            <option value="{{ $jp->nama_pantau }}" {{ $item->jenis_pantau == $jp->nama_pantau ? 'selected' : '' }}>
                                {{ $jp->nama_pantau }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 2. TUJUAN (CHECKBOX MULTIPLE) --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tujuan <small class="text-muted fw-normal">(Bisa pilih lebih dari satu)</small></label>
                    @php
                        // Memastikan data tujuan diproses sebagai array untuk pengecekan checked
                        $tujuanTersimpan = is_array($item->tujuan) ? $item->tujuan : explode(', ', $item->tujuan);
                    @endphp
                    <div class="d-flex flex-wrap gap-3 mt-1">
                        @foreach(['Sekretaris', 'Biro', 'Unit Kerja'] as $tujuan)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tujuan[]" value="{{ $tujuan }}" id="edit_{{ $tujuan }}"
                                    {{ in_array($tujuan, $tujuanTersimpan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="edit_{{ $tujuan }}">{{ $tujuan }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- 3. PEJABAT TTD --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Pejabat TTD</label>
                    <select name="pejabat_ttd" class="form-select border-primary" required>
                        <option value="">-- Pilih --</option>
                        <option value="Kepala Pusat" {{ $item->pejabat_ttd == 'Kepala Pusat' ? 'selected' : '' }}>Kepala Pusat</option>
                        <option value="Kepala BPSDM" {{ $item->pejabat_ttd == 'Kepala BPSDM' ? 'selected' : '' }}>Kepala BPSDM</option>
                    </select>
                </div>

                {{-- 4. PIC (DATA MASTER) --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">PIC (Penanggung Jawab)</label>
                    <select name="pic" class="form-select border-primary" required>
                        <option value="">-- Pilih PIC --</option>
                        @foreach($pics as $p)
                            <option value="{{ $p->nama }}" {{ $item->pic == $p->nama ? 'selected' : '' }}>
                                {{ $p->nama }} ({{ $p->bagian }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 5. STATUS PANTAU (FIELD WAJIB) --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Status Pantau</label>
                    <select name="status_pantau" class="form-select border-primary" required>
                        <option value="">-- Pilih --</option>
                        @foreach(['Proses Penyusunan', 'Proses TTD', 'Terkirim', 'Terkonfirmasi'] as $status)
                            <option value="{{ $status }}" {{ $item->status_pantau == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- 6. BATAS WAKTU (HARI) --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Batas Waktu (Hari)</label>
                    <div class="input-group">
                        <input type="number" name="batas_waktu" class="form-control border-primary" value="{{ $item->batas_waktu }}" required>
                        <span class="input-group-text bg-light text-muted small">Hari</span>
                    </div>
                </div>

                {{-- 7. LAMPIRAN (SCAN SURAT) --}}
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-bold">Lampiran (Scan Surat)</label>
                    <input type="file" name="lampiran" class="form-control border-primary">
                    @if($item->lampiran)
                        <div class="mt-2 small text-muted">
                            <i class="fas fa-file-pdf me-1 text-danger"></i> File saat ini: 
                            <a href="{{ asset('storage/'.$item->lampiran) }}" target="_blank" class="text-decoration-none fw-bold text-primary">Lihat Dokumen</a>
                        </div>
                    @endif
                </div>

                {{-- 8. KETERANGAN (TEXTAREA) --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control border-primary" rows="3" placeholder="Catatan tambahan...">{{ $item->keterangan }}</textarea>
                </div>

                {{-- HIDDEN FIELD --}}
                <input type="hidden" name="deadline_hari" value="{{ $item->deadline_hari ?? 0 }}">
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('daftar-pantau.kepemimpinan.show', $item->kelas_kepemimpinan_id) }}" class="btn btn-light border px-4 rounded-pill">Batal</a>
                <button type="submit" class="btn btn-primary px-4 shadow-sm rounded-pill">
                    <i class="fas fa-save me-1"></i> Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection