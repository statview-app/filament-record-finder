<?php

namespace Statview\FilamentRecordFinder;

use App\Filament\RecordFinders\SubpagesRecordFinder;
use Livewire;
use Illuminate\Support\ServiceProvider;

class FilamentRecordFinderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/forms', 'filament-record-finder');

        // Register the livewire components
        Livewire::component('app.filament.record-finders.subpages-record-finder', SubpagesRecordFinder::class);
    }
}