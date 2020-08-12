<?php

namespace Bakerkretzmar\LaravelMapbox\Facades;

use Illuminate\Support\Facades\Facade;

class Mapbox extends Facade
{
    /**
     * Get the registered name of the component.
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'mapbox';
    }
}
