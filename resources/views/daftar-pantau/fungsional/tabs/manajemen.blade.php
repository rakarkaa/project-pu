@if(auth()->user()->isAdmin())
<form
    action="{{ route('pantau.fungsional.manajemen.store', $kelas->id) }}"
    method="POST"
    enctype="multipart/form-data"
    class="mb-4"
>
    @csrf

    <div class="row">

        {{-- PERIHAL MANAJEMEN --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Perihal Manajemen</label>
            <input type="text" name="perihal_manajemen" class="form-control" required>
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

        {{-- KETERANGAN --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Keterangan</label>
            <select name="keterangan" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="Proses Penyusunan">Proses Penyusunan</option>
                <option value="Proses TTD">Proses TTD</option>
                <option value="Terkirim">Terkirim</option>
                <option value="Terkonfirmasi">Terkonfirmasi</option>
            </select>
        </div>

        {{-- DEADLINE HARI (Disembunyikan / d-none) --}}
        <div class="col-md-4 mb-3 d-none">
            <label class="form-label">Deadline (Hari)</label>
            <input type="number" name="deadline_hari" class="form-control" value="NULL">
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
            <i class="fas fa-save"></i> Simpan Manajemen
        </button>
    </div>
</form>
@endif