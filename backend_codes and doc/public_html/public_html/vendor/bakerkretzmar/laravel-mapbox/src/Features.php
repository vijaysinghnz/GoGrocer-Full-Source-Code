<?php

namespace Bakerkretzmar\LaravelMapbox;

use RunTimeException;

use Zttp\Zttp;

class Features extends MapboxRequest
{
    /**
     * Create a new Features request instance.
     *
     * @param  string       $dataset_id
     * @param  string|null  $feature_id
     */
    public function __construct(string $dataset_id, string $feature_id = null)
    {
        $this->dataset_id = $dataset_id;
        $this->feature_id = $feature_id;
    }

    /**
     * List Features.
     *
     * @see     https://docs.mapbox.com/api/maps/#list-features
     * @return  array
     */
    public function list()
    {
        return Zttp::get($this->url(Mapbox::DATASETS_ENDPOINT, $this->dataset_id, [
            Mapbox::FEATURES_ENDPOINT,
        ]))->json();
    }

    /**
     * Create or update a Feature.
     *
     * @see     https://docs.mapbox.com/api/maps/#insert-or-update-a-feature
     * @param   mixed  $feature
     * @return  array
     */
    public function insert($feature)
    {
        if (! $this->feature_id) {
            throw new RunTimeException('Feature ID required');
        }

        return Zttp::put($this->url(Mapbox::DATASETS_ENDPOINT, $this->dataset_id, [
            Mapbox::FEATURES_ENDPOINT,
            $this->feature_id,
        ]), $feature)->json();
    }

    /**
     * Retrieve a Feature.
     *
     * @see     https://docs.mapbox.com/api/maps/#retrieve-a-feature
     * @return  array
     */
    public function get()
    {
        if (! $this->feature_id) {
            throw new RunTimeException('Feature ID required');
        }

        return Zttp::get($this->url(Mapbox::DATASETS_ENDPOINT, $this->dataset_id, [
            Mapbox::FEATURES_ENDPOINT,
            $this->feature_id,
        ]))->json();
    }

    /**
     * Delete a Feature.
     *
     * @see     https://docs.mapbox.com/api/maps/#delete-a-feature
     * @return  bool
     */
    public function delete()
    {
        if (! $this->feature_id) {
            throw new RunTimeException('Feature ID required');
        }

        return Zttp::delete($this->url(Mapbox::DATASETS_ENDPOINT, $this->dataset_id, [
            Mapbox::FEATURES_ENDPOINT,
            $this->feature_id,
        ]))->status() === Mapbox::DELETE_SUCCESS_STATUS;
    }
}
