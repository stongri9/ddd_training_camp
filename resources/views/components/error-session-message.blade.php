@props(['error'])

@if ($error)
    <div {{ $attributes->merge(['class' => 'sm:px-6 lg:px-8 py-3 font-medium text-sm text-gray-50 bg-red-600']) }}>
        <span>{{ $error }}</span>
    </div>
@endif
