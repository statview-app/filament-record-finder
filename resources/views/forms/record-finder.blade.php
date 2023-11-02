<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    @php
        $addAction = $getAction('add');
        $removeAction = $getAction('remove');
        $items = $getState();
    @endphp

    <div
        x-data="{
            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }}
        }"
        x-on:record-finder-attach-records.window="$wire.dispatchFormEvent('record-finder::addToState', '{{ $getStatePath() }}', $event.detail.recordIds)"
        class="grid gap-3"
    >
        <div>
            <ul class="grid grid-cols-3 gap-3">
                @foreach($items as $uuid => $item)
                    <li class="rounded-lg bg-white shadow p-3 border flex justify-between">
                        <p>{{ $item['title'] }}</p>
                        <span>{{ $removeAction(['item' => $uuid]) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div>
            {{ $addAction }}
        </div>
    </div>
</x-dynamic-component>
