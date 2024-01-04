<?php

namespace Statview\FilamentRecordFinder;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class RecordFinder extends Component implements HasTable, HasForms
{
    use InteractsWithForms;
    use InteractsWithTable {
        makeTable as makeBaseTable;
    }

    public string $statePath;

    public Model $ownerRecord;

    public mixed $existingRecords;

    public ?string $recordFinderComponentId = null;

    public function table(Table $table): Table
    {
        return $table;
    }

    public function makeTable(): Table
    {
        return $this->makeBaseTable()
            ->query(fn($query) => $query->whereNotIn('id', $this->existingRecords))
            ->bulkActions([
                BulkAction::make('attach')
                    ->label('Koppelen')
                    ->action(function (Component $livewire, $records) {
                        $livewire
                            ->dispatch('record-finder-attach-records', recordIds: $records->pluck('id'), statePath: $this->statePath);

                        $livewire
                            ->dispatch('close-modal', id: $this->recordFinderComponentId . '-form-component-action');
                    }),
            ]);
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
