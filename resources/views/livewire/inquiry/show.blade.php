<div class="dark:text-white">
    @if ($inquiries->isNotEmpty())
        <table class="w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr class="border-t border-b border-gray-200 dark:border-gray-700">
                    <th scope="col" class="w-4 px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">ID</th>
                    <th scope="col" class="w-48 px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">氏名</th>
                    <th scope="col" class="w-6 px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">電話番号</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">住所</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">問合せ内容</th>
                    <th scope="col" class="w-[8rem] px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @foreach ($inquiries as $inquiry)
                    <tr wire:key="{{ $inquiry->id }}" class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $inquiry->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $inquiry->last_name }} {{ $inquiry->first_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $inquiry->tel }}</td>
                        <td class="px-6 py-4 text-sm">{{ $inquiry->zip_code }}<br>{{ $inquiry->address }}</td>
                        <td class="px-6 py-4 text-sm" style="white-space: pre-wrap;">{{ $inquiry->content }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <livewire:inquiry.update :id="$inquiry->id" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-4">データはありません！</div>
    @endif
</div>
