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
    <button
        type="button"
        class="flex items-center gap-x-1 bg-gray-100 rounded-full! dark:bg-custom-500/20 px-2 py-1"
        style="{{ \Filament\Support\get_color_css_variables('primary', shades: [100, 500]) }}; min-width: 36px;"
        x-on:click="'{{ filled($modalId) }}' && $dispatch('open-modal', { id: '{{ $modalId }}' })"
        aria-label="{{ $label }}"
    >
        <x-filament-panel-switch::panel-icon
            :icon="$icon"
            :dark-icon="$darkIcon"
            :render-as-image="$renderAsImage"
            class="h-5 w-5 shrink-0"
            :alt="$label"
        />
        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $label }}</span>
    </button>
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
