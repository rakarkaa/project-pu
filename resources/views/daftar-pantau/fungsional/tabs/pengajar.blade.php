@if(auth()->user()->isAdmin())
<form
    action="{{ route('pantau.fungsional.pengajar.store', $kelas->id) }}"
    method="POST"
    enctype="multipart/form-data"
    class="mb-4"
>
    @csrf

    <div class="row">

        {{-- TOTAL PENGAJAR --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Daftar Pengajar</label>
            <input type="text"
                name="daftar_pengajar"
                class="form-control"
                required>
        </div>

        {{-- JENIS PANTAU --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Jenis Pantau</label>
            <select name="jenis_pantau"
                    class="form-select"
                    required>
                <option value="">-- Pilih --</option>
                <option value="Undangan">Undangan</option>
                <option value="Penugasan">Penugasan</option>
            </select>
        </div>

        {{-- DEADLINE HARI --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">
                Deadline Pantau (Hari dari tanggal mulai)
            </label>
            <input type="number"
                   name="deadline_hari"
                   class="form-control"
                   placeholder="contoh: 7"
                   required>
        </div>

        </div>

        {{-- TUJUAN --}}
        <div class="mb-3">
            <label class="form-label">Tujuan</label>
            <input type="text"
                name="tujuan"
                class="form-control"
                required>
        </div>

        {{-- LAMPIRAN --}}
        <div class="mb-3">
            <label class="form-label">
                Lampiran (Opsional)
            </label>
            <input type="file"
                name="lampiran"
                class="form-control">
        </div>

        <div class="text-end">
            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Pengajar
            </button>
        </div>
    </form>
@endif
