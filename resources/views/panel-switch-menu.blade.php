
<x-filament::dropdown
    teleport
    placement="bottom-end"
>
    <x-slot name="trigger">
        <button
            type="button"
            class="group flex w-full items-center justify-center gap-x-3 rounded-lg shadow-sm p-2 text-sm font-medium outline-none bg-primary-500"
        >
            <span class="shrink-0 font-semibold rounded-full w-5 h-5 bg-white text-primary-500">
                {{str($labels[$currentPanel->getId()] ?? $currentPanel->getId())->substr(0, 1)->upper()}}
            </span>
            <span class="text-white">
                {{ $labels[$currentPanel->getId()] ?? str($currentPanel->getId())->ucfirst() }}
            </span>

            <x-filament::icon
                icon="heroicon-m-chevron-down"
                icon-alias="panels::panel-switch-menu.toggle-button"
                class="ms-auto h-5 w-5 shrink-0 text-white"
            />

        </button>
    </x-slot>

    <x-filament::dropdown.list>
        @foreach ($panels as $panel)
            <x-filament::dropdown.list.item
                :href="$canSwitchPanels && $panel->getId() !== $currentPanel->getId() ? config('app.url').'/'.$panel->getPath() : null"
                :badge="str($labels[$panel->getId()] ?? $panel->getId())->substr(0, 2)->upper()"
                tag="a"
            >
                {{ $labels[$panel->getId()] ?? str($panel->getId())->ucfirst() }}
            </x-filament::dropdown.list.item>
        @endforeach
    </x-filament::dropdown.list>

</x-filament::dropdown>
