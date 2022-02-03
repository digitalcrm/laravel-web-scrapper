@props(['id', 'name', 'active'])

@php
    $classActive = ($active ?? false)
    ? 'active'
    : '';
@endphp

<li class="nav-item">
    <a class="nav-link {{ $classActive }}" data-bs-toggle="collapse" aria-current="page"
        href="#{{ $id ?? '' }}">

        {{ $icon ?? 'Button_Name' }}
        {{ $name ?? 'Button_Name' }}
    </a>
</li>
{{ $slot }}
