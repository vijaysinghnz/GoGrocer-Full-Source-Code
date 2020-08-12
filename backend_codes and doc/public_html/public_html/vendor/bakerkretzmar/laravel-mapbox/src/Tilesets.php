<?php

namespace Bakerkretzmar\LaravelMapbox;

use RunTimeException;

use Zttp\Zttp;

class Tilesets extends MapboxRequest
{
    /**
     * Create a new Tileset request instance.
     *
     * @param  string|null  $tileset_id
     */
    public function __construct(string $tileset = null)
    {
        $this->tileset = $tileset;
    }

    /**
     * List Tilesets.
     *
     * @see     https://docs.mapbox.com/api/maps/#list-tilesets
     * @return  array
     */
    public function list()
    {
        return Zttp::get($this->url(Mapbox::TILESETS_ENDPOINT))->json();
    }

    /**
     * Delete a Tileset.
     *
     * @see     https://docs.mapbox.com/api/maps/#delete-tileset
     * @return  bool
     */
    public function delete()
    {
        if (! $this->tileset) {
            throw new RunTimeException('Tileset name required');
        }

        $url = $this->url(Mapbox::TILESETS_ENDPOINT);
        [$url_before, $url_after] = explode('?', $url);
        $url = $url_before . '.' . $this->tileset . '?' . $url_after;

        return Zttp::delete($url)->status() === Mapbox::DELETE_SUCCESS_STATUS;
    }
}
