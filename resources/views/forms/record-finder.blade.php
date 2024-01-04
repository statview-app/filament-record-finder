<x-dynamic-component
        :component="$getFieldWrapperView()"
        :field="$field"
>
    @php
        $addAction = $getAction('add');
        $removeAction = $getAction('remove');
        $linkAction = $getAction('link');
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
                    <li class="rounded-lg bg-white shadow border overflow-hidden">
                        <div class="flex justify-between p-3 bg-gray-50 border-b">
                            <span>{{ $removeAction(['item' => $uuid]) }}</span>

                            <span>{{ $linkAction(['item' => $uuid]) }}</span>
                        </div>

                        <div class="p-3">
                            <p>{{ $item['title'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div>
            {{ $addAction }}
        </div>
    </div>
</x-dynamic-component>
