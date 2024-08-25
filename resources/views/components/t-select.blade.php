@props(['id', 'name', 'value', 'label'])
<div class="position-relative mb-3">
    @isset($label)
        <label for="{{ $id ?? 'id' }}" class="form-label">{{ $label ?? '' }}</label>
    @endisset
    <select class="form-control  @error($name ?? '') is-invalid @enderror" id="{{ $id ?? 'id' }}"
        name="{{ $name ?? 'name' }}" placeholder="{{ $label ?? '' }}" value="{{ $value ?? old($name ?? '') }}"
        autocomplete="off"{!! $attributes !!}>
        {{ $slot }}
    </select>
    @error($name ?? '')
        <div class="invalid-tooltip">
            {{ $message }}
        </div>
    @enderror
</div>
