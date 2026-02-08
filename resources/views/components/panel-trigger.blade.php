@props([
    'icon',
    'darkIcon' => null,
    'renderAsImage' => false,
    'label',
    'topbar' => false,
    'collapsibleSidebar' => false,
    'showChevron' => false,
    'modalId' => null,
])

@if ($topbar)
    <span x-data="{ get isDark() { return $store.theme === 'dark' || ($store.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) } }" class="contents">
        <x-filament::icon-button
            :icon="$icon"
            icon-alias="panels::panel-switch-trigger"
            icon-size="lg"
            :label="$label"
            class="bg-gray-100 rounded-full! dark:bg-custom-500/20"
            style="{{ \Filament\Support\get_color_css_variables('primary', shades: [100, 500]) }}; min-width: 36px;"
            x-show="!isDark"
            x-on:click="'{{ filled($modalId) }}' && $dispatch('open-modal', { id: '{{ $modalId }}' })"
        />
        <x-filament::icon-button
            :icon="$darkIcon ?? $icon"
            icon-alias="panels::panel-switch-trigger"
            icon-size="lg"
            :label="$label"
            class="bg-gray-100 rounded-full! dark:bg-custom-500/20"
            style="{{ \Filament\Support\get_color_css_variables('primary', shades: [100, 500]) }}; min-width: 36px;"
            x-show="isDark"
            x-cloak
            x-on:click="'{{ filled($modalId) }}' && $dispatch('open-modal', { id: '{{ $modalId }}' })"
        />
    </span>
@else
    <button
        x-data="{ tooltip: false }"
        x-effect="
            tooltip = $store.sidebar.isOpen
                ? false
                : {
                      content: @js($label),
                      placement: document.dir === 'rtl' ? 'left' : 'right',
                      theme: $store.theme,
                  }
        "
        x-tooltip.html="tooltip"
        type="button"
        class="fi-sidebar-database-notifications-btn"
    >
        <x-filament-panel-switch::panel-icon
            :icon="$icon"
            :dark-icon="$darkIcon"
            :render-as-image="$renderAsImage"
            class="h-6 w-6 shrink-0 rounded-full object-cover"
            :alt="$label"
        />

        <span
            @if ($collapsibleSidebar)
                x-show="$store.sidebar.isOpen"
                x-transition:enter="fi-transition-enter"
                x-transition:enter-start="fi-transition-enter-start"
                x-transition:enter-end="fi-transition-enter-end"
            @endif
            class="fi-sidebar-database-notifications-btn-label"
        >
            {{ $label }}
        </span>

        @if ($showChevron)
            <x-filament::icon
                icon="heroicon-m-chevron-up"
                @if ($collapsibleSidebar)
                    x-show="$store.sidebar.isOpen"
                    x-transition:enter="fi-transition-enter"
                    x-transition:enter-start="fi-transition-enter-start"
                    x-transition:enter-end="fi-transition-enter-end"
                @endif
                class="ms-auto h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500"
            />
        @endif
    </button>
@endif
