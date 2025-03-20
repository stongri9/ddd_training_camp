<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if($isPublished)
                    <livewire:shift.show />
                @else 
                    <livewire:shift.show-unpublished />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
