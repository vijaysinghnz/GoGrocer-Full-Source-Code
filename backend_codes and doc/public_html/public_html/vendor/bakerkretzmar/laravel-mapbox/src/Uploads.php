<?php

namespace Bakerkretzmar\LaravelMapbox;

use RunTimeException;

use Zttp\Zttp;

class Uploads extends MapboxRequest
{
    /**
     * Create a new Upload request instance.
     *
     * @param  string|null  $upload_id
     */
    public function __construct(string $upload_id = null)
    {
        $this->upload_id = $upload_id;
    }

    /**
     * Retrieve temporary S3 credentials.
     *
     * @see     https://docs.mapbox.com/api/maps/#retrieve-s3-credentials
     * @return  array
     */
    public function credentials()
    {
        return Zttp::get($this->url(Mapbox::UPLOADS_ENDPOINT, null, ['credentials']))->json();
    }

    /**
     * List Uploads.
     *
     * @see     https://docs.mapbox.com/api/maps/#list-datasets
     * @return  array
     */
    public function list()
    {
        return Zttp::get($this->url(Mapbox::UPLOADS_ENDPOINT))->json();
    }

    /**
     * Create an Upload.
     *
     * @see     https://docs.mapbox.com/api/maps/#create-an-upload
     * @param   array  $data
     * @return  array
     */
    public function create(array $data = [])
    {
        if (! isset($data['tileset'])) {
            throw new RunTimeException('Tileset required');
        }

        if (! isset($data['url']) && ! isset($data['dataset'])) {
            throw new RunTimeException('Dataset or URL required');
        }

        if (isset($data['url']) && isset($data['dataset'])) {
            throw new RunTimeException('Dataset OR URL required--not both');
        }

        $data['tileset'] = config('laravel-mapbox.username') . '.' . $data['tileset'];

        if (isset($data['dataset'])) {
            $data['url'] = implode('/', ['mapbox://datasets', config('laravel-mapbox.username'), $data['dataset']]);
            unset($data['dataset']);
        }

        return Zttp::post($this->url(Mapbox::UPLOADS_ENDPOINT), $data)->json();
    }

    /**
     * Retrieve an Upload.
     *
     * @see     https://docs.mapbox.com/api/maps/#retrieve-upload-status
     * @return  array
     */
    public function get()
    {
        if (! $this->upload_id) {
            throw new RunTimeException('Upload ID required');
        }

        return Zttp::get($this->url(Mapbox::UPLOADS_ENDPOINT, $this->upload_id))->json();
    }

    /**
     * Delete an Upload.
     *
     * @see     https://docs.mapbox.com/api/maps/#remove-an-upload-status
     * @return  bool
     */
    public function delete()
    {
        if (! $this->upload_id) {
            throw new RunTimeException('Upload ID required');
        }

        return Zttp::delete($this->url(Mapbox::UPLOADS_ENDPOINT, $this->upload_id))->status() === Mapbox::DELETE_SUCCESS_STATUS;
    }
}
