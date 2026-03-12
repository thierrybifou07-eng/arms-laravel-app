@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-danger small mt-2']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
