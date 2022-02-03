@props(['id', 'show', 'active', 'collaspe' => false])
@php
    $classes = ($active ?? false)
    ? 'active'
    : '';

    $classesShow = ($show ?? false)
    ? 'show'
    : '';
@endphp

@if($collaspe)
    <li class="nav-item ms-3">
        <div class="collapse {{ $classesShow }}" id="{{ $id ?? '' }}">
            <a {{ $attributes->merge(['class' => 'nav-link '. $classes]) }}
                aria-current="page">
                {{ $slot }}
            </a>
        </div>
    </li>
@else
    <li class="nav-item">
        <a {{ $attributes->merge(['class' => 'nav-link '. $classes]) }}
            aria-current="page">
            {{ $slot }}
        </a>
    </li>
@endif
