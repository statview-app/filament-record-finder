<?php

namespace Statview\FilamentRecordFinder\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\Livewire;
use function Livewire\store;

class RecordFinderResourceTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable, InteractsWithForms;

    public string $modelClass = Model::class;

    public ?string $recordFinderComponentId = null;

    private $columns;

    private $query;

    public function mount()
    {
        $storeColumns = store()->get("record-finder-{$this->recordFinderComponentId}-columns") ?? [];
        $storeQuery = store()->get("record-finder-{$this->recordFinderComponentId}-query");

        if ($storeColumns) {
            //session()->put("record-finder-{$this->recordFinderComponentId}-columns", $storeColumns);

            $this->columns = $storeColumns;
        }

        if ($storeQuery) {
            //session()->put("record-finder-{$this->recordFinderComponentId}-query", serialize($storeQuery));

            $this->query = $storeQuery;
        }

        if (!$storeColumns) {
            $this->columns = session()->get("record-finder-{$this->recordFinderComponentId}-columns");
        }

        if (!$storeQuery) {
            $this->query = unserialize(session()->get("record-finder-{$this->recordFinderComponentId}-query"));
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                query: $this->query,
            )
            ->bulkActions([
                BulkAction::make('attach')
                    ->label('Koppelen')
                    ->deselectRecordsAfterCompletion()
                    ->action(function (Component $livewire, $records) {
                        $livewire
                            ->dispatch('record-finder-attach-records', recordIds: $records->pluck('id'));

                        $livewire
                            ->dispatch('close-modal', id: $this->recordFinderComponentId . '-form-component-action');
                    }),
            ])
            ->columns($this->columns ?? []);
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            {{ $this->table }}
        </div>
        HTML;
    }
}