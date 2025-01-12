<section class="space-y-6">
    <x-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'update-inquiry{{$form->id}}')"
    >{{ __('Update Inquiry') }}</x-primary-button>
    
    <x-modal name="update-inquiry{{$form->id}}" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="execute">
            <input type="hidden" id="id" wire:model="form.id">
            <div>
                @error('form.last_name') <span class="error">{{ $message }}</span> @enderror
            </div>
            <label for="last_name" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">姓</label>
            <input type="text" id="last_name" wire:model="form.last_name">
            <div>
                @error('form.first_name') <span class="error">{{ $message }}</span> @enderror
            </div>
            <label for="first_name" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">名</label>
            <input type="text" id="first_name" wire:model="form.first_name">
            <div>
                @error('form.tel') <span class="error">{{ $message }}</span> @enderror
            </div>
            <label for="tel" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">電話番号</label>
            <input type="text" id="tel" wire:model="form.tel" pattern="0[0-9]{9,10}">
            <div>
                @error('form.zip_code') <span class="error">{{ $message }}</span> @enderror
            </div>
            <label for="zip_code" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">郵便番号</label>
            <input type="text" id="zip_code" wire:model="form.zip_code" pattern="[0-9]{7}">
            <div>
                @error('form.address') <span class="error">{{ $message }}</span> @enderror
            </div>
            <label for="address" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">住所</label>
            <input type="text" id="address" wire:model="form.address">
            <div>
                @error('form.content') <span class="error">{{ $message }}</span> @enderror
            </div>
            <label for="content" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">問合せ内容</label>
            <textarea wire:model="form.content"></textarea>
            <div>
                <button type="submit" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">送信</button>
            </div>
            <span wire:loading>Saving...</span>
        </form>
    </x-modal>
</section>


