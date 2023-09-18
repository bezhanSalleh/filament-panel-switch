
@if ($isSimple)
    <x-filament::dropdown teleport placement="bottom-end">
        <x-slot name="trigger">
            <button type="button"
                class="flex items-center justify-center w-full p-2 text-sm font-medium rounded-lg shadow-sm outline-none group gap-x-3 bg-primary-500">
                <span class="w-5 h-5 font-semibold bg-white rounded-full shrink-0 text-primary-500">
                    P
                </span>
                <span class="text-white">
                    {{ str($currentPanel->getId())->ucfirst() }}
                </span>

                <x-filament::icon icon="heroicon-m-chevron-down" icon-alias="panels::panel-switch-menu.toggle-button"
                    class="w-5 h-5 text-white ms-auto shrink-0" />

            </button>
        </x-slot>

        <x-filament::dropdown.list>
            @foreach ($panels as $panel)
                <x-filament::dropdown.list.item :href="$canSwitchPanels && $panel->getId() !== $currentPanel->getId()
                    ? config('app.url') . '/' . $panel->getPath()
                    : null" :badge="str($panel->getId())
                    ->substr(0, 2)
                    ->upper()" tag="a">
                    {{ str($panel->getId())->ucfirst() }}
                </x-filament::dropdown.list.item>
            @endforeach
        </x-filament::dropdown.list>

    </x-filament::dropdown>
@else
    <x-filament::icon-button
        icon="heroicon-s-square-2-stack"
        size="lg"
        @click="$dispatch('open-modal', { id: 'panel-switch' })"
        label="Switch Panels"
        @class(["!rounded-full bg-custom-100 dark:bg-custom-500/20 !w-9 !h-9"])
        style="{{ \Filament\Support\get_color_css_variables('primary', shades: [100, 500]) }};"
    />

    <x-filament::modal
        id="panel-switch"
        :width="$modalWidth"
        alignment="center"
        :slide-over="$isSlideOver"
        class="panel-switch-modal"
    >
        <x-slot name="heading">
            {{ $heading }}
        </x-slot>

        <div
            class="flex flex-wrap items-center justify-center gap-4 md:gap-6"
        >
            @foreach ($panels as $panel)
                <a
                    href="{{ $canSwitchPanels && $panel->getId() !== $currentPanel->getId() ? config('app.url') . '/' . $panel->getPath() : '#' }}"
                    class="flex flex-col items-center justify-center flex-1 hover:cursor-pointer group"
                >
                    <div
                        @class([
                            "p-2 bg-white rounded-lg shadow-md dark:bg-gray-800",
                            "group-hover:ring-2 group-hover:ring-primary-600" => $panel->getId() !== $currentPanel->getId(),
                            "ring-2 ring-primary-600" => $panel->getId() === $currentPanel->getId(),
                        ])
                    >
                        @if ($renderIconAsImage)
                            <img
                                class="rounded-lg"
                                style="width: {{ $iconSize * 4 }}px; height: {{ $iconSize * 4 }}px;"
                                src="{{ $icons[$panel->getId()] ?? 'https://raw.githubusercontent.com/bezhanSalleh/filament-panel-switch/3.x/art/banner.jpg' }}"
                                alt="Panel Image"
                            >
                        @else
                            @php
                                $iconName = $icons[$panel->getId()] ?? 'heroicon-s-square-2-stack' ;
                            @endphp
                            @svg($iconName, 'text-primary-600', ['style' => 'width: ' . ($iconSize * 4) . 'px; height: ' . ($iconSize * 4). 'px;'])
                        @endif
                    </div>
                    <span
                        @class([
                            "mt-2 text-sm font-medium text-center text-gray-400 dark:text-gray-200 break-words",
                            "text-gray-400 dark:text-gray-200 group-hover:text-primary-600 group-hover:dark:text-primary-400" => $panel->getId() !== $currentPanel->getId(),
                            "text-primary-600 dark:text-primary-400" => $panel->getId() === $currentPanel->getId(),
                        ])
                    >
                        Application Management Tool
                    </span>
                </a>
            @endforeach
        </div>
    </x-filament::modal>
@endif
