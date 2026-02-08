@props([
    'icon',
    'darkIcon' => null,
    'renderAsImage' => false,
])

<span x-data="{ get isDark() { return $store.theme === 'dark' || ($store.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) } }" class="contents">
    @if ($renderAsImage)
        <img src="{{ $icon }}" x-show="!isDark" {{ $attributes }} />
        <img src="{{ $darkIcon ?? $icon }}" x-show="isDark" x-cloak {{ $attributes }} />
    @else
        <x-filament::icon :icon="$icon" x-show="!isDark" {{ $attributes }} />
        <x-filament::icon :icon="$darkIcon ?? $icon" x-show="isDark" x-cloak {{ $attributes }} />
    @endif
</span>
