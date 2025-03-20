@props(['success'])

@if ($success)
    <div {{ $attributes->merge(['class' => 'sm:px-6 lg:px-8 py-3 font-medium text-sm text-green-600 dark:text-green-400']) }}>
        <span>{{ $success }}</span>
    </div>
@endif
