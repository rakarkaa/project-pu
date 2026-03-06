@if(auth()->user()->isAdmin())
<form
    action="{{ route('pantau.fungsional.kepesertaan.store', $kelas->id) }}"
    method="POST"
    enctype="multipart/form-data"
    class="mb-4"
>
    @csrf

    <div class="row">

        {{-- TOTAL PESERTA --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Total Peserta</label>
            <input type="number" name="total_peserta" class="form-control" required>
        </div>

        {{-- JENIS PANTAU DINAMIS --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Jenis Pantau</label>
            <select name="jenis_pantau" class="form-select" required>
                <option value="">-- Pilih --</option>
                @foreach($jenisPantau as $jp)
                    <option value="{{ $jp->nama_pantau }}">{{ $jp->nama_pantau }}</option>
                @endforeach
            </select>
        </div>

        {{-- STATUS (Aslinya Keterangan) --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Status</label>
            <select name="keterangan" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="Proses Penyusunan">Proses Penyusunan</option>
                <option value="Proses TTD">Proses TTD</option>
                <option value="Terkirim">Terkirim</option>
                <option value="Terkonfirmasi">Terkonfirmasi</option>
            </select>
        </div>

        {{-- BATAS WAKTU (INPUT ANGKA) --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Batas Waktu (Berapa Hari)</label>
            <input type="number" name="batas_waktu" class="form-control" placeholder="Contoh: 2">
        </div>

        {{-- PEJABAT TTD --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Pejabat TTD</label>
            <select name="pejabat_ttd" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="Kepala Pusat">Kepala Pusat</option>
                <option value="Kepala BPSDM">Kepala BPSDM</option>
            </select>
        </div>

        {{-- KETERANGAN (Aslinya Keterangan Dua, pakai textarea) --}}
        <div class="col-md-12 mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan_dua" class="form-control" rows="3" placeholder="Ketik keterangan tambahan di sini..."></textarea>
        </div>

        {{-- DEADLINE HARI (Disembunyikan / d-none) --}}
        <div class="col-md-4 mb-3 d-none">
            <label class="form-label">Deadline Pantau (Hari dari tanggal mulai)</label>
            <input type="number" name="deadline_hari" class="form-control" placeholder="contoh: 7" value="NULL">
        </div>

        {{-- LAMPIRAN --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Lampiran (Opsional)</label>
            <input type="file" name="lampiran" class="form-control">
        </div>

    </div>

    {{-- TUJUAN --}}
    <div class="mb-3">
        <label class="form-label">Tujuan</label>
        <input type="text" name="tujuan" class="form-control" required>
    </div>

    <div class="text-end">
        <button class="btn btn-primary" type="submit">
            <i class="fas fa-save"></i> Simpan Kepesertaan
        </button>
    </div>
</form>
@endif