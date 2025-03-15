<div class="px-1">
    <x-m-primary-button 
        x-on:click.prevent="$dispatch('open-modal', 'edit-shift')"
    >{{ 'シフト編集' }}</x-m-primary-button>

    <x-modal name="edit-shift" :show="$error->isNotEmpty()" focusable>
        <div>12/1</div>
        <table class="mt-3 border-collapse table-fixed">
            <thead class="bg-slate-50 dark:bg-slate-700">
                <tr>
                    <td></td>
                    <td class="font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">ユーザー名１</td>
                    <td class="font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">ユーザー名２</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-4 text-slate-500 dark:text-slate-400 text-left">12/1</td>
                    <td class="p-4 text-slate-500 dark:text-slate-400 text-center">夜</td>
                    <td class="p-4 text-slate-500 dark:text-slate-400 text-center">休</td>
                </tr>
            </tbody>
        </table>
    </x-modal>
</div>
