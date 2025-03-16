<div class="px-1">
    <x-m-secondary-button 
        x-on:click.prevent="$dispatch('open-modal', 'create-shift')"
    >{{ __('Shift') }}{{ __('Create') }}</x-m-secondary-button>

    <x-modal name="create-shift" focusable maxWidth="sm">
        <form wire:submit="execute" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                {{ __('Shift') }}{{ __('Create') }}
            </h2>
            @error('form.start_date') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            @error('form.end_date') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            <div class="flex justify-between items-center">
                <input type="date" name="start_date" wire:model="form.start_date" class="text-gray-900" />
                <span>〜</span>
                <input type="date" name="end_date" wire:model="form.end_date" class="text-gray-900" />
            </div>
            <div class="mt-6 flex justify-end gap-4">
                <span wire:loading class="text-sm text-gray-500">保存中...</span>
                <x-m-primary-button type="submit">
                    {{ __('Create') }}
                </x-m-primary-button>
            </div>
        </form>
    </x-modal>
</div>
