<?php

namespace Statview\FilamentRecordFinder;

use Illuminate\Support\Facades\Config;
use Livewire;
use Illuminate\Support\ServiceProvider;
use Spatie\StructureDiscoverer\Discover;

class FilamentRecordFinderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/forms', 'filament-record-finder');

        $this->mergeConfigFrom(__DIR__ . '/../config/filament-record-finder.php', 'filament-record-finder');

        $this->publishes([
            __DIR__ . '/../config/filament-record-finder.php' => config_path('filament-record-finder.php'),
        ], 'filament-record-finder-config');

        $this->registerLivewireComponents();
    }

    private function registerLivewireComponents(): void
    {
        $path = Config::get('filament-record-finder.path');

        $components = Discover::in($path)->classes()->get();

        foreach ($components as $component) {
            $componentName = str_replace('\\', '.', $component);

            Livewire::component($componentName, $component);
        }
    }
}