<div class="px-2">
    <x-s-primary-button
        x-on:click.prevent="$dispatch('open-modal', 'apply-shift{{ $form->id }}')"
    >{{ __('Apply') }}</x-s-primary-button>

    <x-modal name="apply-shift{{ $form->id }}" :show="$errors->isNotEmpty()" focusable>
        <div class="p-6">
            <h2 class="text-2xl font-medium text-gray-900 dark:text-gray-100">12/1</h2>
            <table class="mt-3 border-collapse table-fixed">
                <thead class="bg-slate-50 dark:bg-slate-700">
                    <tr>
                        <td class="font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">シフト</td>
                        <td class="font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">ユーザー名</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-4 text-slate-500 dark:text-slate-400 text-left">日勤</td>
                        <td class="p-4 text-slate-500 dark:text-slate-400 text-center">
                            <select class="text-black">
                                <option>ユーザー名１</option>
                                <option>ユーザー名２</option>
                                <option>ユーザー名３</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-modal>
</div>
