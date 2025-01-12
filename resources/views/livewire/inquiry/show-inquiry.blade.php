<div>
    @if ($inquiries->isNotEmpty())
        @foreach ($inquiries as $inquiry)
            <div wire:key="{{ $inquiry->id }}">id: {{ $inquiry->id }}</div>
            <div>姓名：{{ $inquiry->last_name }} {{ $inquiry->first_name }}</div>
            <div>電話番号：{{ $inquiry->tel }}</div>
            <div>住所：{{ $inquiry->zip_code }} {{ $inquiry->address }}</div>
            <div>問合せ内容：{{ $inquiry->content }}</div>
            <livewire:inquiry.update-inquiry :id="$inquiry->id" />
        @endforeach
    @else
        <div>データはありません！</div>
    @endif
</div>
