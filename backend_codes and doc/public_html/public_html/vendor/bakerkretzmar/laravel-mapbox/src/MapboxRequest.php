<?php

namespace Bakerkretzmar\LaravelMapbox;

abstract class MapboxRequest
{
    protected $dataset_id;

    protected $feature_id;

    protected $tileset;

    protected $upload_id;

    protected function url(string $endpoint, string $id = null, array $options = [])
    {
        $segments = [
            config('laravel-mapbox.url'),
            $endpoint,
            config('laravel-mapbox.version'),
            config('laravel-mapbox.username'),
        ];

        if ($id) {
            $segments[] = $id;
        }

        if (! empty($options)) {
            $segments = array_merge($segments, $options);
        }

        return 'https://' . implode('/', $segments) . '?access_token=' . config('laravel-mapbox.token');
    }
}
