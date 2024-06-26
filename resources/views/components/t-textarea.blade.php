@props(['id', 'name', 'label', 'value', 'r'])
<div class="position-relative mb-3">
    <label for="{{ $id ?? 'id' }}" class="form-label">{{ $label ?? '' }}</label>
    <textarea name="{{ $name ?? '' }}" id="{{ $id ?? '' }}" rows="{{ $r ?? 3 }}"
        class="form-control @error($name ?? '') is-invalid @enderror">{{ $value ?? '' }}</textarea>
    @error($name ?? '')
        <div class="invalid-tooltip">
            {{ $message }}
        </div>
    @enderror
</div>
