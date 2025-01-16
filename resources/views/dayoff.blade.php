<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ '休暇申請' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <header class="flex justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        <a href="#"><<</a>　 {{ '12月' }}　 <a href="#">>></a>
                        </h2>
                        <div>
                            <x-m-primary-button>編集</x-m-primary-button>
                        </div>
                    </header>
                    <table class="mt-3 border-collapse table-fixed">
                        <thead class="bg-slate-50 dark:bg-slate-700">
                            <tr>
                                <td></td>
                                <td class="font-semibold p-4 text-slate-900 dark:text-slate-200 text-center">申請ステータス</td>
                                <td class="font-semibold p-4 text-slate-900 dark:text-slate-200 text-left">コメント</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-4 text-slate-500 dark:text-slate-400 text-left">12/1</td>
                                <td class="p-4 text-slate-500 dark:text-slate-400 text-center">申請中</td>
                                <td class="p-4 text-slate-500 dark:text-slate-400 text-left">ほげほげほげほげ</td>
                            </tr>
                            <tr>
                                <td class="p-4 text-slate-500 dark:text-slate-400 text-left">12/2</td>
                                <td class="p-4 text-slate-500 dark:text-slate-400 text-center">申請済</td>
                                <td class="p-4 text-slate-500 dark:text-slate-400 text-left">ほげほげほげほげ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
