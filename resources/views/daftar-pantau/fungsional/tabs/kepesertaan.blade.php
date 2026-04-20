@if(auth()->user()->isAdmin())
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
        {{-- 2. TUJUAN (CHECKBOX MULTIPLE)              --}}
        {{-- ========================================== --}}
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Tujuan <small class="text-muted fw-normal">(Bisa pilih lebih dari satu)</small></label>
            <div class="d-flex flex-wrap gap-3 mt-1">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tujuan[]" value="Sekretaris" id="tujuan_sekretaris">
                    <label class="form-check-label" for="tujuan_sekretaris">Sekretaris</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tujuan[]" value="Biro" id="tujuan_biro">
                    <label class="form-check-label" for="tujuan_biro">Biro</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tujuan[]" value="Unit Kerja" id="tujuan_unit_kerja">
                    <label class="form-check-label" for="tujuan_unit_kerja">Unit Kerja</label>
                </div>
            </div>
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
            <i class="fas fa-save me-1"></i> Simpan Kepesertaan
        </button>
    </div>
</form>
@endif