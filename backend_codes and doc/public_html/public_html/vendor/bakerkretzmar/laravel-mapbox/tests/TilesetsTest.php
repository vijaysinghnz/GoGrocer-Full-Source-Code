<?php

namespace Bakerkretzmar\LaravelMapbox\Tests;

use Mapbox;

class TilesetsTest extends TestCase
{
    /** @test */
    public function list_tilesets()
    {
        $response = Mapbox::tilesets()->list();

        $this->assertTrue(is_array($response));
        // @todo
        // $this->assertValidTilesetResponse($response);
    }

    /** @test */
    // public function delete_tileset()
    // {
    //     $response = Mapbox::tilesets('test_tileset_4')->delete();

    //     $this->assertTrue($response);
    // }
}
