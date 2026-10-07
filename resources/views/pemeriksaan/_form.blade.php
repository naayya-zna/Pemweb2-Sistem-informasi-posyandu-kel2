<div class="row">

    {{-- Warga --}}
    <div class="col-md-6 mb-3">
        <label for="warga_id" class="form-label">Warga</label>

        <select name="warga_id" id="warga_id"
                class="form-select @error('warga_id') is-invalid @enderror"
                required>

            <option value="">-- Pilih Warga --</option>

            @foreach ($wargas as $warga)
                <option value="{{ $warga->id }}"
                    {{ old('warga_id', $pemeriksaan->warga_id ?? '') == $warga->id ? 'selected' : '' }}>
                    {{ $warga->nama }} - {{ $warga->nik }}
                </option>
            @endforeach

        </select>

        @error('warga_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    {{-- Jadwal --}}
    <div class="col-md-6 mb-3">
        <label for="jadwal_id" class="form-label">Jadwal</label>

        <select name="jadwal_id" id="jadwal_id"
                class="form-select @error('jadwal_id') is-invalid @enderror"
                required>

            <option value="">-- Pilih Jadwal --</option>

            @foreach ($jadwals as $jadwal)
                <option value="{{ $jadwal->id }}"
                    {{ old('jadwal_id', $pemeriksaan->jadwal_id ?? '') == $jadwal->id ? 'selected' : '' }}>

                    {{ $jadwal->tanggal?->format('d/m/Y') }}
                    -
                    {{ $jadwal->lokasi ?? 'Lokasi tidak tersedia' }}

                </option>
            @endforeach

        </select>

        @error('jadwal_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    {{-- Pemeriksa --}}
    <div class="col-md-6 mb-3">
        <label for="pemeriksa_id" class="form-label">Pemeriksa</label>

        <select name="pemeriksa_id" id="pemeriksa_id"
                class="form-select @error('pemeriksa_id') is-invalid @enderror"
                required>

            <option value="">-- Pilih Pemeriksa --</option>

            @foreach ($users as $user)
                <option value="{{ $user->id }}"
                    {{ old('pemeriksa_id', $pemeriksaan->pemeriksa_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach

        </select>

        @error('pemeriksa_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    {{-- Tanggal --}}
    <div class="col-md-6 mb-3">
        <label for="tanggal" class="form-label">Tanggal Pemeriksaan</label>

        <input type="date"
               name="tanggal"
               id="tanggal"
               class="form-control @error('tanggal') is-invalid @enderror"
               value="{{ old('tanggal', isset($pemeriksaan->tanggal) ? $pemeriksaan->tanggal->format('Y-m-d') : '') }}"
               required>

        @error('tanggal')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    {{-- Berat Badan --}}
    <div class="col-md-3 mb-3">
        <label for="berat_badan" class="form-label">Berat Badan (kg)</label>

        <input type="number"
               step="0.01"
               name="berat_badan"
               id="berat_badan"
               class="form-control"
               value="{{ old('berat_badan', $pemeriksaan->berat_badan ?? '') }}">
    </div>


    {{-- Tinggi Badan --}}
    <div class="col-md-3 mb-3">
        <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>

        <input type="number"
               step="0.01"
               name="tinggi_badan"
               id="tinggi_badan"
               class="form-control"
               value="{{ old('tinggi_badan', $pemeriksaan->tinggi_badan ?? '') }}">
    </div>


    {{-- Lingkar Kepala --}}
    <div class="col-md-3 mb-3">
        <label for="lingkar_kepala" class="form-label">
            Lingkar Kepala (cm)
        </label>

        <input type="number"
               step="0.01"
               name="lingkar_kepala"
               id="lingkar_kepala"
               class="form-control"
               value="{{ old('lingkar_kepala', $pemeriksaan->lingkar_kepala ?? '') }}">
    </div>


    {{-- Lingkar Lengan --}}
    <div class="col-md-3 mb-3">
        <label for="lingkar_lengan" class="form-label">
            Lingkar Lengan (cm)
        </label>

        <input type="number"
               step="0.01"
               name="lingkar_lengan"
               id="lingkar_lengan"
               class="form-control"
               value="{{ old('lingkar_lengan', $pemeriksaan->lingkar_lengan ?? '') }}">
    </div>


    {{-- Tekanan Darah --}}
    <div class="col-md-6 mb-3">
        <label for="tekanan_darah" class="form-label">
            Tekanan Darah
        </label>

        <input type="text"
               name="tekanan_darah"
               id="tekanan_darah"
               class="form-control"
               placeholder="Contoh: 120/80"
               value="{{ old('tekanan_darah', $pemeriksaan->tekanan_darah ?? '') }}">
    </div>


    {{-- Gula Darah --}}
    <div class="col-md-6 mb-3">
        <label for="gula_darah" class="form-label">
            Gula Darah (mg/dL)
        </label>

        <input type="number"
               step="0.01"
               name="gula_darah"
               id="gula_darah"
               class="form-control"
               value="{{ old('gula_darah', $pemeriksaan->gula_darah ?? '') }}">
    </div>


    {{-- Status Gizi --}}
    <div class="col-md-6 mb-3">
        <label for="status_gizi" class="form-label">
            Status Gizi
        </label>

        <select name="status_gizi" id="status_gizi" class="form-select">

            <option value="">-- Pilih Status Gizi --</option>

            @foreach (['Sangat Kurus', 'Kurus', 'Normal', 'Gemuk', 'Obesitas'] as $status)
                <option value="{{ $status }}"
                    {{ old('status_gizi', $pemeriksaan->status_gizi ?? '') == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach

        </select>
    </div>


    {{-- Keluhan --}}
    <div class="col-md-6 mb-3">
        <label for="keluhan" class="form-label">Keluhan</label>

        <textarea name="keluhan"
                  id="keluhan"
                  rows="3"
                  class="form-control">{{ old('keluhan', $pemeriksaan->keluhan ?? '') }}</textarea>
    </div>


    {{-- Catatan --}}
    <div class="col-12 mb-3">
        <label for="catatan" class="form-label">Catatan</label>

        <textarea name="catatan"
                  id="catatan"
                  rows="4"
                  class="form-control">{{ old('catatan', $pemeriksaan->catatan ?? '') }}</textarea>
    </div>

</div>