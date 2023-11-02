<?php

namespace Statview\FilamentRecordFinder;

use Livewire;
use Illuminate\Support\ServiceProvider;
use Statview\FilamentRecordFinder\Livewire\RecordFinderResourceTable;

class FilamentRecordFinderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views/forms', 'filament-record-finder');

        Livewire::component('filament-record-finder::resource-table', RecordFinderResourceTable::class);
    }
}