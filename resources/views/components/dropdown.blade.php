@props(['align' => 'right', 'width' => '48', 'contentClasses' => ''])

@php
$alignmentClasses = match ($align) {
    'left' => 'dropdown-menu-start',
    'top' => 'dropdown',
    default => 'dropdown-menu-end',
};

$widthClass = match ($width) {
    '48' => 'w-75',
    default => '',
};
@endphp

<div class="dropdown">
    <div class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $trigger }}
    </div>

    <div class="dropdown-menu {{ $alignmentClasses }} {{ $widthClass }} {{ $contentClasses }}" style="">
        {{ $content }}
    </div>
</div>
