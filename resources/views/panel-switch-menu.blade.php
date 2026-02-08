@php
    $hasTopbar = $currentPanel->hasTopbar();
    $isSidebarCollapsibleOnDesktop = filament()->isSidebarCollapsibleOnDesktop();
    $currentLabel = $labels[$currentPanel->getId()] ?? str($currentPanel->getId())->ucfirst();
    $currentIcon = $icons[$currentPanel->getId()] ?? 'heroicon-o-square-2-stack';
    $currentDarkIcon = $darkIcons[$currentPanel->getId()] ?? $currentIcon;
    $defaultIcon = 'heroicon-o-square-2-stack';
@endphp

@if ($isSimple)
    {{-- SIMPLE MODE: Dropdown --}}
    <x-filament::dropdown
        teleport
        :placement="$hasTopbar ? 'bottom-end' : 'top-start'"
    >
        <x-slot name="trigger">
            <x-filament-panel-switch::panel-trigger
                :icon="$currentIcon"
                :dark-icon="$currentDarkIcon"
                :render-as-image="$renderIconAsImage"
                :label="$currentLabel"
                :topbar="$hasTopbar"
                :collapsible-sidebar="$isSidebarCollapsibleOnDesktop"
                :show-chevron="! $hasTopbar"
            />
        </x-slot>

        {{-- Dropdown list --}}
        <x-filament::dropdown.list>
            @foreach ($panels as $id => $url)
                @php
                    $isCurrentPanel = $id === $currentPanel->getId();
                    $panelLabel = $labels[$id] ?? str($id)->ucfirst();
                    $panelIcon = $icons[$id] ?? $defaultIcon;
                    $panelDarkIcon = $darkIcons[$id] ?? null;
                @endphp

                <span x-data="{ get isDark() { return $store.theme === 'dark' || ($store.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches) } }" class="contents">
                    @if ($isCurrentPanel)
                        <x-filament::dropdown.list.item
                            :icon="$panelIcon"
                            icon-color="primary"
                            color="primary"
                            tag="div"
                            class="pointer-events-none"
                            x-show="!isDark"
                        >
                            <span class="flex items-center justify-between gap-x-2 w-full">
                                <span class="text-primary-600 dark:text-primary-400">{{ $panelLabel }}</span>
                                <x-filament::icon
                                    icon="heroicon-m-check"
                                    class="h-4 w-4 text-primary-600 dark:text-primary-400"
                                />
                            </span>
                        </x-filament::dropdown.list.item>
                        <x-filament::dropdown.list.item
                            :icon="$panelDarkIcon ?? $panelIcon"
                            icon-color="primary"
                            color="primary"
                            tag="div"
                            class="pointer-events-none"
                            x-show="isDark"
                            x-cloak
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
                            x-show="!isDark"
                        >
                            {{ $panelLabel }}
                        </x-filament::dropdown.list.item>
                        <x-filament::dropdown.list.item
                            :href="$url"
                            :icon="$panelDarkIcon ?? $panelIcon"
                            tag="a"
                            x-show="isDark"
                            x-cloak
                        >
                            {{ $panelLabel }}
                        </x-filament::dropdown.list.item>
                    @endif
                </span>
            @endforeach
        </x-filament::dropdown.list>
    </x-filament::dropdown>

@else
    @if ($hasTopbar)
        <div>
            <x-filament-panel-switch::panel-trigger
                :icon="$currentIcon"
                :dark-icon="$currentDarkIcon"
                :render-as-image="$renderIconAsImage"
                :label="$heading"
                :topbar="true"
                modal-id="panel-switch"
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

                <x-filament-panel-switch::panel-list
                    :panels="$panels"
                    :current-panel="$currentPanel"
                    :labels="$labels"
                    :icons="$icons"
                    :dark-icons="$darkIcons"
                    :icon-size="$iconSize"
                    :render-icon-as-image="$renderIconAsImage"
                    :slide-over="$isSlideOver"
                />
            </x-filament::modal>
        </div>
    @else
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
                <x-filament-panel-switch::panel-trigger
                    :icon="$currentIcon"
                    :dark-icon="$currentDarkIcon"
                    :render-as-image="$renderIconAsImage"
                    :label="$heading"
                    :collapsible-sidebar="$isSidebarCollapsibleOnDesktop"
                />
            </x-slot>

            <x-slot name="heading">
                {{ $heading }}
            </x-slot>

            <x-filament-panel-switch::panel-list
                :panels="$panels"
                :current-panel="$currentPanel"
                :labels="$labels"
                :icons="$icons"
                :dark-icons="$darkIcons"
                :icon-size="$iconSize"
                :render-icon-as-image="$renderIconAsImage"
                :slide-over="$isSlideOver"
            />
        </x-filament::modal>
    @endif
@endif

@once
    @unless($isSlideOver)
        <style>
            .panel-switch-modal .fi-modal-content {
                align-items: center !important;
                justify-content: center !important;
            }
        </style>
    @endunless
@endonce