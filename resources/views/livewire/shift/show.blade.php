<div class="p-6 text-gray-900 dark:text-gray-100">
    <header class="flex justify-between items-center px-4 py-3 border-b border-gray-100 dark:border-gray-700">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Published') }}{{ __('Shift') }}{{ __('List') }}
        </h2>
        <div class="flex justify-between gap-2">
            <livewire:shift.create />
            <x-m-primary-button>
                <a href="{{ route('shift.edit', [
                        'start_date' => $current_start_date, 
                        'end_date' => $current_end_date,
                        'is_published_edit' => true,
                    ], false) }}">
                    {{ __('Shift') }}{{ __('Edit') }}
                </a>
            </x-m-primary-button>
            <x-m-tertiary-button>
                <a href="{{ route('shift.unpublished', ['latest_date' => $current_start_date], false) }}">
                    {{ __('Unpublished') }}{{ __('Shift') }}
                </a>
            </x-m-tertiary-button>
        </div>
    </header>
    <div class="px-3 mt-3">
        <span class="px-2 py-1 text-xs font-semibold rounded-lg" style="background-color: red">日勤</span>
        <span class="px-2 py-1 text-xs font-semibold rounded-lg" style="background-color: green">遅番</span>
        <span class="px-2 py-1 text-xs font-semibold rounded-lg" style="background-color: blue">夜勤</span>
    </div>
    <div class="flex justify-between mt-3">
        @if ($shifts->isNotEmpty())
            <table class="border-collapse table-fixed">
                <tbody>
                    @foreach ($shifts as $shift)                    
                        <tr>
                            <td class="p-4 text-slate-500 dark:text-slate-400 text-left">{{ $shift->date }}</td>
                            @foreach ($shift->shiftAssignments as $assignment)
                                <td class="p-4 text-slate-500 dark:text-slate-400 text-center">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-lg" style="background-color: {{ $assignment->shift_type->color() }}">
                                        {{ $assignment->user->name }}
                                    </span>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="border-collapse table-fixed">
                <tbody>
                    @foreach ($shifts as $shift)
                        <tr>         
                            <td class="px-4 text-slate-500 dark:text-slate-400 text-center">
                                <livewire:shift.apply :id="$shift->id" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-4">データはありません！</div>
        @endif
    </div>
</div>
