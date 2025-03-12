<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div>
        <div class="py-2">
            <div>
                <livewire:weather-component/>
            </div>
        </div>
        <div>
            <div>
                <livewire:forecast-component/>
            </div>
        </div>
    </div>
</x-app-layout>
