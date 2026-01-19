@props([
    'panels',
    'currentPanel',
    'labels' => [],
    'icons' => [],
    'renderIconAsImage' => false,
])

@php
    $defaultIcon = 'heroicon-o-square-2-stack';
    $defaultImage = 'https://raw.githubusercontent.com/bezhanSalleh/filament-panel-switch/3.x/art/banner.jpg';
@endphp

<ul class="space-y-2">
    @foreach ($panels as $id => $url)
        @php
            $isCurrentPanel = $id === $currentPanel->getId();
            $panelLabel = $labels[$id] ?? str($id)->ucfirst();
            $panelIcon = $icons[$id] ?? $defaultIcon;
        @endphp

        <li>
            <a
                href="{{ $url }}"
                @class([
                    "flex items-center gap-x-4 p-3 rounded-xl transition duration-75",
                    "hover:bg-gray-50 dark:hover:bg-white/5" => ! $isCurrentPanel,
                    "bg-primary-50 dark:bg-primary-400/10 pointer-events-none" => $isCurrentPanel,
                ])
            >
                {{-- Icon --}}
                @if ($renderIconAsImage)
                    <img
                        class="h-10 w-10 shrink-0 rounded-lg object-cover"
                        src="{{ $icons[$id] ?? $defaultImage }}"
                        alt="{{ $panelLabel }}"
                    >
                @else
                    <x-filament::icon
                        :icon="$panelIcon"
                        @class([
                            "h-6 w-6 shrink-0",
                            "text-gray-400 dark:text-gray-500" => ! $isCurrentPanel,
                            "text-primary-600 dark:text-primary-400" => $isCurrentPanel,
                        ])
                    />
                @endif

                {{-- Label --}}
                <span
                    @class([
                        "flex-1 text-sm font-medium",
                        "text-gray-700 dark:text-gray-200" => ! $isCurrentPanel,
                        "text-primary-600 dark:text-primary-400" => $isCurrentPanel,
                    ])
                >
                    {{ $panelLabel }}
                </span>

                {{-- Indicator --}}
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
    @endforeach
</ul>
