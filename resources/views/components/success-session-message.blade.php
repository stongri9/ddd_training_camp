@props(['success'])

@if ($success)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 dark:text-green-400']) }}>
        <span>{{ $success }}</span>
    </div>
@endif
