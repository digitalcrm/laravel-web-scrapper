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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-file" aria-hidden="true">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                {{ $slot }}
            </a>
        </div>
    </li>
@else
    <li class="nav-item">
        <a {{ $attributes->merge(['class' => 'nav-link '. $classes]) }}
            aria-current="page">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-home" aria-hidden="true">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            {{ $slot }}
        </a>
    </li>
@endif
