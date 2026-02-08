@props([
    'panels',
    'currentPanel',
    'labels' => [],
    'icons' => [],
    'darkIcons' => [],
    'iconSize' => 32,
    'renderIconAsImage' => false,
    'slideOver' => false,
])

@php
    $defaultIcon = $slideOver ? 'heroicon-o-square-2-stack' : 'heroicon-s-square-2-stack';
    $defaultImage = 'https://raw.githubusercontent.com/bezhanSalleh/filament-panel-switch/3.x/art/banner.jpg';
    $tag = $slideOver ? 'ul' : 'div';
    $tagClasses = match ($tag) {
        'ul' => 'space-y-2',
        default => 'flex flex-wrap items-center justify-center gap-4 md:gap-6'
    };
@endphp

<{{ $tag }} class="{{ $tagClasses }}">
    @foreach ($panels as $id => $url)
        @php
            $isCurrentPanel = $id === $currentPanel->getId();
            $panelLabel = $labels[$id] ?? str($id)->ucfirst();
            $panelIcon = $icons[$id] ?? ($renderIconAsImage ? $defaultImage : $defaultIcon);
            $panelDarkIcon = $darkIcons[$id] ?? null;
        @endphp

        @if ($slideOver)
            <li>
                <a
                    href="{{ $url }}"
                    @class([
                        "flex items-center gap-x-4 p-3 rounded-xl transition duration-75",
                        "hover:bg-gray-50 dark:hover:bg-white/5" => ! $isCurrentPanel,
                        "bg-primary-50 dark:bg-primary-400/10 pointer-events-none" => $isCurrentPanel,
                    ])
                >
                    <x-filament-panel-switch::panel-icon
                        :icon="$panelIcon"
                        :dark-icon="$panelDarkIcon"
                        :render-as-image="$renderIconAsImage"
                        @class([
                            'h-10 w-10 shrink-0 rounded-lg object-cover' => $renderIconAsImage,
                            'h-6 w-6 shrink-0' => ! $renderIconAsImage,
                            'text-gray-400 dark:text-gray-500' => ! $renderIconAsImage && ! $isCurrentPanel,
                            'text-primary-600 dark:text-primary-400' => ! $renderIconAsImage && $isCurrentPanel,
                        ])
                        :alt="$panelLabel"
                    />

                    <span
                        @class([
                            "flex-1 text-sm font-medium",
                            "text-gray-700 dark:text-gray-200" => ! $isCurrentPanel,
                            "text-primary-600 dark:text-primary-400" => $isCurrentPanel,
                        ])
                    >
                        {{ $panelLabel }}
                    </span>

                    @if ($isCurrentPanel)
                        <x-filament::icon
                            icon="heroicon-m-check-circle"
                            class="h-5 w-5 shrink-0 text-primary-600 dark:text-primary-400"
                        />
                    @else
                        <x-filament::icon
                            icon="heroicon-m-chevron-right"
                            class="h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500"
                        />
                    @endif
                </a>
            </li>
        @else
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
                    <x-filament-panel-switch::panel-icon
                        :icon="$panelIcon"
                        :dark-icon="$panelDarkIcon"
                        :render-as-image="$renderIconAsImage"
                        @class([
                            'text-primary-600 panel-switch-card-icon' => ! $renderIconAsImage,
                            'rounded-lg panel-switch-card-image' => $renderIconAsImage,
                        ])
                        :style="'width: ' . ($iconSize * 4) . 'px; height: ' . ($iconSize * 4) . 'px;'"
                        :alt="$panelLabel"
                    />
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
        @endif
    @endforeach
</{{ $tag }}>
