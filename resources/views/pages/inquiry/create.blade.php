<section class="space-y-6">
    <x-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'create-inquiry')"
    >{{ __('Create Inquiry') }}</x-primary-button>
    <x-modal name="create-inquiry" focusable>
        <livewire:inquiry.create-inquiry />
    </x-modal>
</section>

