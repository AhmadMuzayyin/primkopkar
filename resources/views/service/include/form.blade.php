<x-t-input t="text" id="nama" name="nama" label="Nama Layanan" value="{{ $service->nama ?? '' }}" />
<x-t-textarea id="deskripsi" name="deskripsi" label="Deskripsi" value="{{ $service->deskripsi ?? '' }}" />
<x-t-input t="number" id="harga_per_m3" name="harga_per_m3" label="Harga Per M3"
    value="{{ $service->harga_per_m3 ?? '' }}" />
<x-t-input t="number" id="harga_per_angkutan" name="harga_per_angkutan" label="Harga Per Angkutan"
    value="{{ $service->harga_per_angkutan ?? '' }}" />
<x-t-input t="number" id="volume_max" name="volume_max" label="Volume Maksimal"
    value="{{ $service->volume_max ?? '' }}" />
<x-t-input t="number" id="persentase_komisi" name="persentase_komisi" label="Persentase Komisi"
    value="{{ $service->persentase_komisi ?? '' }}" />
