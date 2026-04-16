@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$maxWidth = [
    'sm' => 'modal-sm',
    'md' => '',
    'lg' => 'modal-lg',
    'xl' => 'modal-xl',
    '2xl' => 'modal-xl',
][$maxWidth] ?? '';
@endphp

<div class="modal fade" id="modal-{{ $name }}" tabindex="-1" role="dialog" aria-labelledby="modal-{{ $name }}-label" aria-hidden="true">
    <div class="modal-dialog {{ $maxWidth }}" role="document">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>
