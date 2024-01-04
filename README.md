# This package is a WIP
## Installation
```bash
composer require statview/filament-record-finder
```

## Create record finder classes

```php
use App\Models\User;
use Filament\Tables\Columns;
use Filament\Tables\Table;
use Statview\FilamentRecordFinder\RecordFinder;

class RecordFinderDemo extends RecordFinder
{
    public function table(Table $table)
    {
        return $table
            ->query(
                fn () => User::query()
                    ->whereNotIn('id', $this->existingRecord)
            )
            ->columns([
                Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
            ]);
    }
}
```

## Usage
```php
use Filament\Tables\Columns\TextColumn;
use Statview\FilamentRecordFinder\Forms\RecordFinder;

RecordFinder::make('pages')
    ->label('Subpages')
    ->relation('pages', 'title')
    ->grid()
    ->recordFinder(RecordFinderDemo::class),
```
