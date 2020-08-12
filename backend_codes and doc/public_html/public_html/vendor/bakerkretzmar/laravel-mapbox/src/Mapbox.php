<?php

namespace Bakerkretzmar\LaravelMapbox;

use RunTimeException;

class Mapbox
{
    /**
     * Mapbox API endpoint names and status codes.
     */
    const DATASETS_ENDPOINT = 'datasets';
    const TILESETS_ENDPOINT = 'tilesets';
    const FEATURES_ENDPOINT = 'features';
    const UPLOADS_ENDPOINT = 'uploads';
    const DELETE_SUCCESS_STATUS = 204;

    protected $config;

    /**
     * Create a new instance of the Mapbox API wrapper.
     *
     * @param  array  $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Create a new Datasets request.
     *
     * @param   string|null  $dataset_id
     * @return  Datasets
     */
    public function datasets(string $dataset_id = null)
    {
        return new Datasets($dataset_id);
    }

    /**
     * Shortcut to create a new Features request for a given Dataset.
     *
     * @param   string       $dataset_id
     * @param   string|null  $feature_id
     * @return  Features
     */
    public function features(string $dataset_id, string $feature_id = null)
    {
        if (! $dataset_id) {
            throw new RunTimeException('Dataset ID required');
        }

        return new Features($dataset_id, $feature_id);
    }

    /**
     * Create a new Tilesets request.
     *
     * @param   string|null  $tileset_id
     * @return  Tilesets
     */
    public function tilesets(string $tileset_id = null)
    {
        return new Tilesets($tileset_id);
    }

    /**
     * Create a new Uploads request.
     *
     * @param   string|null  $upload_id
     * @return  Uploads
     */
    public function uploads(string $upload_id = null)
    {
        return new Uploads($upload_id);
    }
}
