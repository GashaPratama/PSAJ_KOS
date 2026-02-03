@props([
    'sidebar' => false,
    'href' => '/',
])

@if($sidebar)
    <a href="{{ $href }}" {{ $attributes->class('h-10 flex items-center px-2 text-xl font-bold text-zinc-900 dark:text-white in-data-flux-sidebar-collapsed-desktop:hidden') }}>
        Nama Kos
    </a>
@else
    <a href="{{ $href }}" {{ $attributes->class('h-10 flex items-center gap-2 text-xl font-extrabold tracking-tight text-zinc-900 dark:text-white lg:text-3xl') }}>
        Nama Kos
    </a>
@endif
