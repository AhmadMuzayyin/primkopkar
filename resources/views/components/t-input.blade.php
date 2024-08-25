@props(['id', 'name', 'value', 'label' => null, 't', 'r'])
<div class="position-relative mb-3">
    @if (isset($label))
        <label for="{{ $id ?? 'id' }}" class="form-label">{{ $label ?? '' }}</label>
    @endif
    <input type="{{ $t }}" class="form-control @error($name ?? '') is-invalid @enderror"
        id="{{ $id ?? 'id' }}" name="{{ $name ?? 'name' }}" {{ $label ?? `placeholder="$label"` }}
        value="{{ $value ?? old($name ?? '') }}" required autocomplete="off" {{ $r ?? '' }} {!! $attributes !!}>
    {{ $slot }}
    @error($name ?? '')
        <div class="invalid-tooltip">
            {{ $message }}
        </div>
    @enderror
</div>
