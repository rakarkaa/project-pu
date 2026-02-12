@if(auth()->user()->isAdmin())
<form
    action="{{ route('pantau.fungsional.manajemen.store', $kelas->id) }}"
    method="POST"
    enctype="multipart/form-data"
>
@csrf

        <div class="col-md-4 mb-3">
            <label class="form-label">Perihal Manajemen</label>
            <input type="text"
                name="perihal_manajemen"
                class="form-control"
                required>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Jenis Pantau</label>
                <select name="jenis_pantau" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="Undangan">Undangan</option>
                    <option value="Penugasan">Penugasan</option>
                </select>
            </div>

            <div class="col-md-4 mb-3 d-none">
                <label class="form-label">Deadline (Hari)</label>
                <input type="number" name="deadline_hari" class="form-control" value="NULL">
            </div>
        </div>

        {{-- LAMPIRAN --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">
                Lampiran (Opsional)
            </label>
            <input type="file"
                name="lampiran"
                class="form-control">
        </div>


        {{-- TUJUAN --}}
        <div class="mb-3">
            <label class="form-label">Tujuan</label>
            <input type="text"
                name="tujuan"
                class="form-control"
                required>
        </div>

        <div class="text-end">
            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Manajemen
            </button>
        </div>
        </form>
        @endif
