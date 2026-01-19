@php
    $hasTopbar = $currentPanel->hasTopbar();
    $isSidebarCollapsibleOnDesktop = filament()->isSidebarCollapsibleOnDesktop();
    $currentLabel = $labels[$currentPanel->getId()] ?? str($currentPanel->getId())->ucfirst();
    $currentIcon = $icons[$currentPanel->getId()] ?? 'heroicon-o-square-2-stack';
    $defaultIcon = 'heroicon-o-square-2-stack';
    $defaultImage = 'https://raw.githubusercontent.com/bezhanSalleh/filament-panel-switch/3.x/art/banner.jpg';
@endphp

@if ($isSimple)
    {{-- SIMPLE MODE: Dropdown --}}
    <x-filament::dropdown
        teleport
        :placement="$hasTopbar ? 'bottom-end' : 'top-start'"
    >
        <x-slot name="trigger">
            @if ($hasTopbar)
                {{-- Topbar trigger --}}
                <x-filament::icon-button
                    :icon="$currentIcon"
                    icon-alias="panels::panel-switch-trigger"
                    icon-size="lg"
                    :label="$currentLabel"
                    @class(["bg-gray-100 !rounded-full dark:bg-custom-500/20"])
                    style="{{ \Filament\Support\get_color_css_variables('primary', shades: [100, 500]) }}; min-width: 36px;"
                />
            @else
                {{-- Sidebar trigger --}}
                <button
                    x-data="{ tooltip: false }"
                    x-effect="
                        tooltip = $store.sidebar.isOpen
                            ? false
                            : {
                                  content: @js($currentLabel),
                                  placement: document.dir === 'rtl' ? 'left' : 'right',
                                  theme: $store.theme,
                              }
                    "
                    x-tooltip.html="tooltip"
                    type="button"
                    class="fi-sidebar-database-notifications-btn"
                >
                    @if ($renderIconAsImage)
                        <img
                            src="{{ $icons[$currentPanel->getId()] ?? $defaultImage }}"
                            alt="{{ $currentLabel }}"
                            class="h-6 w-6 shrink-0 rounded-full object-cover"
                        />
                    @else
                        <x-filament::icon
                            :icon="$currentIcon"
                            class="h-6 w-6 shrink-0"
                        />
                    @endif

                    <span
                        @if ($isSidebarCollapsibleOnDesktop)
                            x-show="$store.sidebar.isOpen"
                            x-transition:enter="fi-transition-enter"
                            x-transition:enter-start="fi-transition-enter-start"
                            x-transition:enter-end="fi-transition-enter-end"
                        @endif
                        class="fi-sidebar-database-notifications-btn-label"
                    >
                        {{ $currentLabel }}
                    </span>

                    <x-filament::icon
                        icon="heroicon-m-chevron-up"
                        @if ($isSidebarCollapsibleOnDesktop)
                            x-show="$store.sidebar.isOpen"
                            x-transition:enter="fi-transition-enter"
                            x-transition:enter-start="fi-transition-enter-start"
                            x-transition:enter-end="fi-transition-enter-end"
                        @endif
                        class="ms-auto h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500"
                    />
                </button>
            @endif
        </x-slot>

        {{-- Dropdown list (shared for both topbar and sidebar) --}}
        <x-filament::dropdown.list>
            @foreach ($panels as $id => $url)
                @php
                    $isCurrentPanel = $id === $currentPanel->getId();
                    $panelLabel = $labels[$id] ?? str($id)->ucfirst();
                    $panelIcon = $icons[$id] ?? $defaultIcon;
                @endphp

                @if ($isCurrentPanel)
                    <x-filament::dropdown.list.item
                        :icon="$panelIcon"
                        icon-color="primary"
                        color="primary"
                        tag="div"
                        class="pointer-events-none"
                    >
                        <span class="flex items-center justify-between gap-x-2 w-full">
                            <span class="text-primary-600 dark:text-primary-400">{{ $panelLabel }}</span>
                            <x-filament::icon
                                icon="heroicon-m-check"
                                class="h-4 w-4 text-primary-600 dark:text-primary-400"
                            />
                        </span>
                    </x-filament::dropdown.list.item>
                @else
                    <x-filament::dropdown.list.item
                        :href="$url"
                        :icon="$panelIcon"
                        tag="a"
                    >
                        {{ $panelLabel }}
                    </x-filament::dropdown.list.item>
                @endif
            @endforeach
        </x-filament::dropdown.list>
    </x-filament::dropdown>

@else
    {{-- MODAL MODE --}}

    {{-- CSS for centered modal (non-slideover) --}}
    @unless ($isSlideOver)
        <style>
            .panel-switch-modal .fi-modal-content {
                align-items: center !important;
                justify-content: center !important;
            }
        </style>
    @endunless

    @if ($hasTopbar)
        {{-- Topbar: Icon button trigger with separate modal --}}
        <div>
            <x-filament::icon-button
                x-data="{}"
                :icon="$currentIcon"
                icon-alias="panels::panel-switch-trigger"
                icon-size="lg"
                @click="$dispatch('open-modal', { id: 'panel-switch' })"
                :label="$heading"
                @class(["bg-gray-100 !rounded-full dark:bg-custom-500/20"])
                style="{{ \Filament\Support\get_color_css_variables('primary', shades: [100, 500]) }}; min-width: 36px;"
            />

            <x-filament::modal
                id="panel-switch"
                :width="$isSlideOver ? 'md' : $modalWidth"
                :alignment="$isSlideOver ? null : 'center'"
                :slide-over="$isSlideOver"
                :sticky-header="$isSlideOver"
                display-classes="block"
                :class="$isSlideOver ? '' : 'panel-switch-modal'"
            >
                <x-slot name="heading">
                    {{ $heading }}
                </x-slot>

                @if ($isSlideOver)
                    <x-filament-panel-switch::slide-over-list
                        :panels="$panels"
                        :current-panel="$currentPanel"
                        :labels="$labels"
                        :icons="$icons"
                        :render-icon-as-image="$renderIconAsImage"
                    />
                @else
                    <x-filament-panel-switch::card-grid
                        :panels="$panels"
                        :current-panel="$currentPanel"
                        :labels="$labels"
                        :icons="$icons"
                        :icon-size="$iconSize"
                        :render-icon-as-image="$renderIconAsImage"
                    />
                @endif
            </x-filament::modal>
        </div>
    @else
        {{-- Sidebar: Modal with inline trigger --}}
        <x-filament::modal
            id="panel-switch"
            :slide-over="$isSlideOver"
            :sticky-header="$isSlideOver"
            :width="$isSlideOver ? 'md' : $modalWidth"
            teleport="body"
            :alignment="$isSlideOver ? null : 'center'"
            :class="$isSlideOver ? '' : 'panel-switch-modal'"
        >
            <x-slot name="trigger">
                <button
                    x-data="{ tooltip: false }"
                    x-effect="
                        tooltip = $store.sidebar.isOpen
                            ? false
                            : {
                                  content: @js($heading),
                                  placement: document.dir === 'rtl' ? 'left' : 'right',
                                  theme: $store.theme,
                              }
                    "
                    x-tooltip.html="tooltip"
                    type="button"
                    class="fi-sidebar-database-notifications-btn"
                >
                    @if ($renderIconAsImage)
                        <img
                            src="{{ $icons[$currentPanel->getId()] ?? $defaultImage }}"
                            alt="{{ $currentLabel }}"
                            class="h-6 w-6 shrink-0 rounded-full object-cover"
                        />
                    @else
                        <x-filament::icon
                            :icon="$currentIcon"
                            class="h-6 w-6 shrink-0"
                        />
                    @endif

                    <span
                        @if ($isSidebarCollapsibleOnDesktop)
                            x-show="$store.sidebar.isOpen"
                            x-transition:enter="fi-transition-enter"
                            x-transition:enter-start="fi-transition-enter-start"
                            x-transition:enter-end="fi-transition-enter-end"
                        @endif
                        class="fi-sidebar-database-notifications-btn-label"
                    >
                        {{ $heading }}
                    </span>
                </button>
            </x-slot>

            <x-slot name="heading">
                {{ $heading }}
            </x-slot>

            @if ($isSlideOver)
                <x-filament-panel-switch::slide-over-list
                    :panels="$panels"
                    :current-panel="$currentPanel"
                    :labels="$labels"
                    :icons="$icons"
                    :render-icon-as-image="$renderIconAsImage"
                />
            @else
                <x-filament-panel-switch::card-grid
                    :panels="$panels"
                    :current-panel="$currentPanel"
                    :labels="$labels"
                    :icons="$icons"
                    :icon-size="$iconSize"
                    :render-icon-as-image="$renderIconAsImage"
                />
            @endif
        </x-filament::modal>
    @endif
@endif
