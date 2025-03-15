<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <header class="flex justify-between items-center px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ '月のシフト一覧' }}
                        </h2>
                        <div class="flex justify-between">
                            <livewire:shift.update />
                            <x-m-secondary-button>シフト生成</x-m-primary-button>
                        </div>
                    </header>
                    <div class="flex justify-between mt-3">
                        <table class="border-collapse table-fixed">
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
                                <tr>
                                    <td class="p-4 text-slate-500 dark:text-slate-400 text-left">12/2</td>
                                    <td class="p-4 text-slate-500 dark:text-slate-400 text-center">休</td>
                                    <td class="p-4 text-slate-500 dark:text-slate-400 text-center">夜</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="border-collapse table-fixed">
                            <thead class="bg-slate-50 dark:bg-slate-700">
                                <tr><td class="font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">　</td></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-4 text-slate-500 dark:text-slate-400 text-center">
                                        <x-s-primary-button>変更</x-s-primary-button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 text-slate-500 dark:text-slate-400">
                                        <x-s-primary-button>変更</x-s-primary-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
