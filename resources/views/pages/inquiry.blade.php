<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inquiry') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <div class="px-3 pb-3 flex justify-end">
            <livewire:inquiry.create-inquiry />
        </div>
        <livewire:inquiry.show-inquiry />
    </div>
    </div>
    </div>
</x-app-layout>
