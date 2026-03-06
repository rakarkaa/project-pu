@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h1 class="h3 mb-0 text-gray-800">Edit Data Pemantauan Kepemimpinan</h1>
    <a href="{{ route('daftar-pantau.kepemimpinan.show', $item->kelas_kepemimpinan_id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-edit me-1"></i> Form Edit Data</h6>
    </div>
    <div class="card-body">
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pantau.kepesertaan.update', $item->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Total Peserta</label>
                    <input type="number" name="total_peserta" class="form-control" value="{{ $item->total_peserta }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Jenis Pantau</label>
                    <select name="jenis_pantau" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        @foreach($jenisPantau as $jp)
                            <option value="{{ $jp->nama_pantau }}" {{ $item->jenis_pantau == $jp->nama_pantau ? 'selected' : '' }}>
                                {{ $jp->nama_pantau }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status Dokumen</label>
                    <select name="keterangan" class="form-select" required>
                        <option value="Proses Penyusunan" {{ $item->keterangan == 'Proses Penyusunan' ? 'selected' : '' }}>Proses Penyusunan</option>
                        <option value="Proses TTD" {{ $item->keterangan == 'Proses TTD' ? 'selected' : '' }}>Proses TTD</option>
                        <option value="Terkirim" {{ $item->keterangan == 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
                        <option value="Terkonfirmasi" {{ $item->keterangan == 'Terkonfirmasi' ? 'selected' : '' }}>Terkonfirmasi</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pejabat TTD</label>
                    <select name="pejabat_ttd" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Kepala Pusat" {{ $item->pejabat_ttd == 'Kepala Pusat' ? 'selected' : '' }}>Kepala Pusat</option>
                        <option value="Kepala BPSDM" {{ $item->pejabat_ttd == 'Kepala BPSDM' ? 'selected' : '' }}>Kepala BPSDM</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Batas Waktu</label>
                    <div class="input-group">
                        @php
                            $editSisaHari = '';
                            if ($item->batas_waktu) {
                                $todayEdit = \Carbon\Carbon::now()->startOfDay();
                                $tglBatasEdit = \Carbon\Carbon::parse($item->batas_waktu)->startOfDay();
                                $diffEdit = intval($todayEdit->diffInDays($tglBatasEdit, false));
                                $editSisaHari = $diffEdit < 0 ? 0 : $diffEdit;
                            }
                        @endphp
                        <input type="number" name="batas_waktu" class="form-control" value="{{ $editSisaHari }}" placeholder="Contoh: 2">
                        <span class="input-group-text bg-light">Hari</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Scan Dokumen Surat (Opsional)</label>
                    <input type="file" name="lampiran" class="form-control">
                    @if($item->lampiran)
                        <small class="d-block mt-2 text-muted">File saat ini: <a href="{{ asset('storage/'.$item->lampiran) }}" target="_blank">Lihat File</a></small>
                    @endif
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tujuan</label>
                    <input type="text" name="tujuan" class="form-control" value="{{ $item->tujuan }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Keterangan Tambahan</label>
                    <textarea name="keterangan_dua" class="form-control" rows="2">{{ $item->keterangan_dua }}</textarea>
                </div>
            </div>

            <hr class="mt-4">
            <div class="text-end">
                <a href="{{ route('daftar-pantau.kepemimpinan.show', $item->kelas_kepemimpinan_id) }}" class="btn btn-light border me-2">Batal</a>
                <button type="submit" class="btn btn-primary px-4 shadow-sm"><i class="fas fa-save me-1"></i> Update Data</button>
            </div>
        </form>
    </div>
</div>
@endsection