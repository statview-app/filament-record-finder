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
                statePath: '{{ $getStatePath() }}',
                state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }},
                handleAttachRecords($event) {
                    if ($event.detail.statePath != this.statePath) {
                        return;
                    }

                    $wire.dispatchFormEvent('record-finder::addToState', '{{ $getStatePath() }}', $event.detail.recordIds)
                },
            }"
            x-on:record-finder-attach-records.window="($event) => handleAttachRecords($event)"
            class="grid gap-3"
    >
        <div>
            <x-filament::grid
                    :default="$getGridColumns('default')"
                    :sm="$getGridColumns('sm')"
                    :md="$getGridColumns('md')"
                    :lg="$getGridColumns('lg')"
                    :xl="$getGridColumns('xl')"
                    :two-xl="$getGridColumns('2xl')"
                    class="gap-3"
            >
                @foreach($items as $uuid => $item)
                    <div class="rounded-lg bg-white shadow border overflow-hidden">
                        <div class="flex justify-between p-3 bg-gray-50 border-b">
                            <span>{{ $removeAction(['item' => $uuid]) }}</span>

                            <span>{{ $linkAction(['item' => $uuid]) }}</span>
                        </div>

                        <div class="p-3">
                            <p>{{ $item['title'] }}</p>
                        </div>
                    </div>
                @endforeach
            </x-filament::grid>
        </div>

        <div>
            {{ $addAction }}
        </div>
    </div>
</x-dynamic-component>
