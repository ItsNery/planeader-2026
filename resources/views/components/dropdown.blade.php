@props(['id', 'active'])

@php
    $classes = $active ?? false ? 'nav-link active font-weight-bolder' : 'nav-link';
@endphp

<li class="nav-item dropdown">
    <a id="{{ $id }}" {!! $attributes->merge(['class' => $classes]) !!} role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $trigger }}
    </a>

    <div class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="{{ $id }}">
        {{ $content }}
    </div>
</li>
