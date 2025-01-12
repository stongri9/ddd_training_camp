<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inquiry') }}
        </h2>
    </x-slot>
    <livewire:inquiry.create-inquiry />
    <livewire:inquiry.show-inquiry />
</x-app-layout>
