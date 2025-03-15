<section>
    <x-m-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'update-inquiry{{$form->id}}')"
    >{{ __('Edit') }}</x-m-primary-button>
    
    <x-modal name="update-inquiry{{$form->id}}" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="execute" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                {{ __('Inquiry') }}{{ __('Update') }}
            </h2>

            <input type="hidden" id="id" wire:model="form.id">
            
            <div class="grid gap-4">
                <div class="grid gap-2">
                    <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">姓</label>
                    <input type="text" id="last_name" wire:model="form.last_name" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('form.last_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid gap-2">
                    <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">名</label>
                    <input type="text" id="first_name" wire:model="form.first_name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('form.first_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid gap-2">
                    <label for="tel" class="block text-sm font-medium text-gray-700 dark:text-gray-300">電話番号</label>
                    <input type="text" id="tel" wire:model="form.tel" pattern="0[0-9]{9,10}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('form.tel') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid gap-2">
                    <label for="zip_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">郵便番号</label>
                    <input type="text" id="zip_code" wire:model="form.zip_code" pattern="[0-9]{7}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('form.zip_code') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid gap-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">住所</label>
                    <input type="text" id="address" wire:model="form.address"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('form.address') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid gap-2">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">問合せ内容</label>
                    <textarea wire:model="form.content" id="content" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                    @error('form.content') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-center gap-4 items-center">
                <span wire:loading class="text-sm text-gray-500">保存中...</span>
                <x-m-primary-button type="submit">
                    {{ __('Update') }}
                </x-m-primary-button>
            </div>
        </form>
    </x-modal>
</section>


