@props([
    'panels',
    'currentPanel',
    'labels' => [],
    'icons' => [],
    'darkIcons' => [],
    'iconSize' => 32,
    'renderIconAsImage' => false,
    'renderDarkIconAsImage' => false,
])

@php
    $defaultIcon = 'heroicon-s-square-2-stack';
    $defaultImage = 'https://raw.githubusercontent.com/bezhanSalleh/filament-panel-switch/3.x/art/banner.jpg';
@endphp

<div class="flex flex-wrap items-center justify-center gap-4 md:gap-6">
    @foreach ($panels as $id => $url)
        @php
            $isCurrentPanel = $id === $currentPanel->getId();
            $panelLabel = $labels[$id] ?? str($id)->ucfirst();
            $panelIcon = $icons[$id] ?? $defaultIcon;
            $darkPanelIcon = $darkIcons[$id] ?? null;
        @endphp

        <a
            href="{{ $url }}"
            class="flex flex-col items-center justify-center hover:cursor-pointer group panel-switch-card"
        >
            <div
                @class([
                    "p-2 bg-white rounded-lg shadow-md dark:bg-gray-800 panel-switch-card-section",
                    "group-hover:ring-2 group-hover:ring-primary-600" => ! $isCurrentPanel,
                    "ring-2 ring-primary-600" => $isCurrentPanel,
                ])
            >
                @if ($darkPanelIcon)
                    @if ($renderIconAsImage)
                        <span class="fi-panel-switch-light">
                            <img
                                class="rounded-lg panel-switch-card-image"
                                style="width: {{ $iconSize * 4 }}px; height: {{ $iconSize * 4 }}px;"
                                src="{{ $icons[$id] ?? $defaultImage }}"
                                alt="{{ $panelLabel }}"
                            >
                        </span>
                    @else
                        <span class="fi-panel-switch-light">
                            @svg($panelIcon, 'text-primary-600 panel-switch-card-icon', ['style' => 'width: ' . ($iconSize * 4) . 'px; height: ' . ($iconSize * 4). 'px;'])
                        </span>
                    @endif

                    @if ($renderDarkIconAsImage)
                        <span class="fi-panel-switch-dark">
                            <img
                                class="rounded-lg panel-switch-card-image"
                                style="width: {{ $iconSize * 4 }}px; height: {{ $iconSize * 4 }}px;"
                                src="{{ $darkPanelIcon }}"
                                alt="{{ $panelLabel }}"
                            >
                        </span>
                    @else
                        <span class="fi-panel-switch-dark">
                            @svg($darkPanelIcon, 'text-primary-600 panel-switch-card-icon', ['style' => 'width: ' . ($iconSize * 4) . 'px; height: ' . ($iconSize * 4). 'px;'])
                        </span>
                    @endif
                @else
                    @if ($renderIconAsImage)
                        <img
                            class="rounded-lg panel-switch-card-image"
                            style="width: {{ $iconSize * 4 }}px; height: {{ $iconSize * 4 }}px;"
                            src="{{ $icons[$id] ?? $defaultImage }}"
                            alt="{{ $panelLabel }}"
                        >
                    @else
                        @svg($panelIcon, 'text-primary-600 panel-switch-card-icon', ['style' => 'width: ' . ($iconSize * 4) . 'px; height: ' . ($iconSize * 4). 'px;'])
                    @endif
                @endif
            </div>
            <span
                @class([
                    "mt-2 text-sm font-medium text-center break-words panel-switch-card-title",
                    "text-gray-400 dark:text-gray-200 group-hover:text-primary-600 group-hover:dark:text-primary-400" => ! $isCurrentPanel,
                    "text-primary-600 dark:text-primary-400" => $isCurrentPanel,
                ])
            >
                {{ $panelLabel }}
            </span>
        </a>
    @endforeach
</div>
