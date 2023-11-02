<?php

namespace Statview\FilamentRecordFinder\Livewire;

use App\Synths\Objects\ColumnsArray;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class RecordFinderResourceTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable, InteractsWithForms;

    public ?ColumnsArray $columns = null;

    public string $modelClass = Model::class;

    public ?string $recordFinderComponentId = null;

    public array $existingRecordIds = [];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                query: $this->modelClass::query()
                    ->whereNotIn('id', $this->existingRecordIds),
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
            ->columns($this->columns->get());
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