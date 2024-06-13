@props(['id', 'title', 'lg'])
<div class="modal fade" id="{{ $id ?? 'modal' }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog {{ $lg ?? '' }}">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">{{ $title ?? 'Large modal' }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{ $slot }}

        </div>
    </div>
</div>
