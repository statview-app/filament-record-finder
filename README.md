# This package is a WIP
## Installation
```bash
composer require statview/filament-record-finder
```

## Usage
```php
use Filament\Tables\Columns\TextColumn;
use Statview\FilamentRecordFinder\Forms\RecordFinder;

RecordFinder::make('pages')
    ->label('Subpages')
    ->relation('pages', 'title')
    ->columns([
        TextColumn::make('title')
            ->searchable()
            ->sortable(),
    ]),
```

## Known limitations
* You can only use `TextColumn` in your columns
* Not all methods are supported yet for a `TextColumn`
* You cannot use closures in `TextColumn` methods