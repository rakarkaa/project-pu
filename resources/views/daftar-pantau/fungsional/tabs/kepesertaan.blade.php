@if(auth()->user()->isAdmin())

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<form
    action="{{ route('pantau.fungsional.kepesertaan.store', $kelas->id) }}"
    method="POST"
    enctype="multipart/form-data"
    class="mb-4"
>
    @csrf

    <div class="row">

        {{-- ========================================== --}}
        {{-- 1. JENIS PANTAU DINAMIS                    --}}
        {{-- ========================================== --}}
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Jenis Pantau</label>
            <select name="jenis_pantau" class="form-select" required>
                <option value="">-- Pilih --</option>
                @foreach($jenisPantau as $jp)
                    <option value="{{ $jp->nama_pantau }}">{{ $jp->nama_pantau }}</option>
                @endforeach
            </select>
        </div>

        {{-- ========================================== --}}
        {{-- 2. TUJUAN (SELECT2 MULTI-SELECT)           --}}
        {{-- ========================================== --}}
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Tujuan <small class="text-muted fw-normal">(Pilih satu atau lebih)</small></label>
            
            {{-- Memanggil CSS Select2 --}}
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

            <select name="tujuan[]" id="selectTujuanCreate" class="form-select" multiple="multiple" required style="width: 100%;">
                @php
                    $listTujuanMaster = \App\Models\TujuanPenerimaSurat::all();
                @endphp
                @foreach($listTujuanMaster as $tujuan)
                    <option value="{{ $tujuan->nama_unitkerja }}">
                        {{ $tujuan->nama_unitorganisasi }} - {{ $tujuan->nama_unitkerja }}
                    </option>
                @endforeach
            </select>
        </div>


        {{-- ========================================== --}}
        {{-- 3. PEJABAT TTD                             --}}
        {{-- ========================================== --}}
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Pejabat TTD</label>
            <select name="pejabat_ttd" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="Kepala Pusat">Kepala Pusat</option>
                <option value="Kepala BPSDM">Kepala BPSDM</option>
            </select>
        </div>

        {{-- ========================================== --}}
        {{-- 4. PIC (DATA MASTER) - BARU                --}}
        {{-- ========================================== --}}
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">PIC (Penanggung Jawab)</label>
            <select name="pic" class="form-select" required>
                <option value="">-- Pilih PIC --</option>
                @foreach($pics as $p)
                    <option value="{{ $p->nama }}">{{ $p->nama }} ({{ $p->bagian }})</option>
                @endforeach
            </select>
        </div>

        {{-- ========================================== --}}
        {{-- 5. BATAS WAKTU (INPUT ANGKA HARI)          --}}
        {{-- ========================================== --}}
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Batas Waktu (Berapa Hari)</label>
            <input type="number" name="batas_waktu" class="form-control" placeholder="Contoh: 2">
        </div>

        {{-- ========================================== --}}
        {{-- 6. STATUS PANTAU                           --}}
        {{-- ========================================== --}}
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Status</label>
            {{-- name diseragamkan menjadi status_pantau --}}
            <select name="status_pantau" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="Proses Penyusunan">Proses Penyusunan</option>
                <option value="Proses TTD">Proses TTD</option>
                <option value="Terkirim">Terkirim</option>
                <option value="Terkonfirmasi">Terkonfirmasi</option>
            </select>
        </div>

        {{-- ========================================== --}}
        {{-- 7. KETERANGAN TEXTAREA                     --}}
        {{-- ========================================== --}}
        <div class="col-md-12 mb-3">
            <label class="form-label fw-semibold">Keterangan</label>
            {{-- name diseragamkan menjadi keterangan --}}
            <textarea name="keterangan" class="form-control" rows="3" placeholder="Ketik keterangan tambahan di sini..."></textarea>
        </div>

        {{-- ========================================== --}}
        {{-- 8. LAMPIRAN (FILE UPLOAD)                  --}}
        {{-- ========================================== --}}
        <div class="col-md-12 mb-3">
            <label class="form-label fw-semibold">Lampiran (Opsional)</label>
            <input type="file" name="lampiran" class="form-control">
        </div>

        {{-- HIDDEN: DEADLINE HARI --}}
        <div class="col-md-4 mb-3 d-none">
            <input type="number" name="deadline_hari" value="0">
        </div>

    </div>

    {{-- TOMBOL SIMPAN --}}
    <div class="text-end mt-2">
        <button class="btn btn-primary px-4" type="submit">
            <i class="fas fa-save me-1"></i> Simpan
        </button>
    </div>
</form>

@push('scripts')
{{-- Ganti script lama dengan ini. Jangan panggil jquery.min.js lagi di sini --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi Select2 dengan ID yang benar: selectTujuanCreate
        // Serta tambahkan width: '100%' agar tidak gepeng saat form muncul
        $('#selectTujuanCreate').select2({
            placeholder: "-- Pilih Tujuan --",
            allowClear: true,
            width: '100%' 
        });

        // Logika tambahan: Jika form dibuka, pastikan Select2 menyesuaikan ukuran
        $('#btnTambahPantau').on('click', function() {
            setTimeout(function() {
                $('#selectTujuanCreate').select2({
                    placeholder: "-- Pilih Tujuan --",
                    allowClear: true,
                    width: '100%'
                });
            }, 100);
        });
    });
</script>
@endpush
@endif