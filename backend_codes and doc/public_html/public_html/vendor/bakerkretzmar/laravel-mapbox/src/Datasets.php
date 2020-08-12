<?php

namespace Bakerkretzmar\LaravelMapbox;

use RunTimeException;

use Zttp\Zttp;

class Datasets extends MapboxRequest
{
    /**
     * Create a new Dataset request instance.
     *
     * @param  string|null  $dataset_id
     */
    public function __construct(string $dataset_id = null)
    {
        $this->dataset_id = $dataset_id;
    }

    /**
     * List Datasets.
     *
     * @see     https://docs.mapbox.com/api/maps/#list-datasets
     * @return  array
     */
    public function list()
    {
        return Zttp::get($this->url(Mapbox::DATASETS_ENDPOINT))->json();
    }

    /**
     * Create a Dataset.
     *
     * @see     https://docs.mapbox.com/api/maps/#create-a-dataset
     * @param   array  $data
     * @return  array
     */
    public function create(array $data = [])
    {
        return Zttp::post($this->url(Mapbox::DATASETS_ENDPOINT), $data)->json();
    }

    /**
     * Retrieve a Dataset.
     *
     * @see     https://docs.mapbox.com/api/maps/#retrieve-a-dataset
     * @return  array
     */
    public function get()
    {
        if (! $this->dataset_id) {
            throw new RunTimeException('Dataset ID required');
        }

        return Zttp::get($this->url(Mapbox::DATASETS_ENDPOINT, $this->dataset_id))->json();
    }

    /**
     * Update a Dataset.
     *
     * @see     https://docs.mapbox.com/api/maps/#update-a-dataset
     * @param   array  $data
     * @return  array
     */
    public function update(array $data)
    {
        if (! $this->dataset_id) {
            throw new RunTimeException('Dataset ID required');
        }

        return Zttp::patch($this->url(Mapbox::DATASETS_ENDPOINT, $this->dataset_id), $data)->json();
    }

    /**
     * Delete a Dataset.
     *
     * @see     https://docs.mapbox.com/api/maps/#delete-a-dataset
     * @return  bool
     */
    public function delete()
    {
        if (! $this->dataset_id) {
            throw new RunTimeException('Dataset ID required');
        }

        return Zttp::delete($this->url(Mapbox::DATASETS_ENDPOINT, $this->dataset_id))->status() === Mapbox::DELETE_SUCCESS_STATUS;
    }

    /**
     * Create a new Features request for the current Dataset.
     *
     * @param   string|null  $feature_id
     * @return  Features
     */
    public function features(string $feature_id = null)
    {
        if (! $this->dataset_id) {
            throw new RunTimeException('Dataset ID required');
        }

        return new Features($this->dataset_id, $feature_id);
    }
}
