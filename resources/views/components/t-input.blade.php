@props(['id', 'name', 'value', 'label', 't', 'r'])
<div class="position-relative mb-3">
    <label for="{{ $id ?? 'id' }}" class="form-label">{{ $label ?? '' }}</label>
    <input type="{{ $t }}" class="form-control @error($name ?? '') is-invalid @enderror"
        id="{{ $id ?? 'id' }}" name="{{ $name ?? 'name' }}" placeholder="{{ $label ?? '' }}"
        value="{{ $value ?? old($name ?? '') }}" required autocomplete="off" {{ $r ?? '' }} {!! $attributes !!}>
    @error($name ?? '')
        <div class="invalid-tooltip">
            {{ $message }}
        </div>
    @enderror
</div>
