@php
    $services = App\Models\Service::all();
@endphp
<x-t-select id="service_id" name="service_id" label="Service">
    <option value="" selected disabled>Pilih Service</option>
    @foreach ($services as $service)
        <option value="{{ $service->id }}"
            {{ isset($provider) && $provider->service_id == $service->id ? 'selected' : '' }}>
            {{ $service->nama }}</option>
    @endforeach
</x-t-select>
<x-t-input t="text" id="nama" name="nama" label="Nama" value="{{ $provider->nama ?? '' }}" />
<x-t-input t="text" id="alamat" name="alamat" label="Alamat" value="{{ $provider->alamat ?? '' }}" />
<x-t-input t="number" min="62" id="no_telp" name="no_telp" label="No Telp"
    value="{{ $provider->no_telp ?? '' }}" />
