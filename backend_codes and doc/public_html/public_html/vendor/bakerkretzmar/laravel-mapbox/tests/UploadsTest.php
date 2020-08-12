<?php

namespace Bakerkretzmar\LaravelMapbox\Tests;

use Mapbox;

use Bakerkretzmar\LaravelMapbox\Models\S3Credentials;

class UploadsTest extends TestCase
{
    protected function tearDown(): void
    {
        if ($this->upload) {
            while (isset($this->upload['complete']) && $this->upload['complete'] != true) {
                sleep(1);
                $this->upload = Mapbox::uploads($this->upload['id'])->get();
            }

            Mapbox::uploads($this->upload['id'])->delete();
        }

        $tilesets = Mapbox::tilesets()->list();

        while (in_array($this->tileset, array_column($tilesets, 'name'))) {
            Mapbox::tilesets($this->tileset)->delete();
            sleep(1);
            $tilesets = Mapbox::tilesets()->list();
        }

        if ($this->dataset) {
            Mapbox::datasets($this->dataset['id'])
                ->delete();
        }

        parent::tearDown();
    }

    /** @test */
    public function get_credentials()
    {
        $credentials = Mapbox::uploads()->credentials();

        $this->assertArrayHasKey('bucket', $credentials);
        $this->assertArrayHasKey('key', $credentials);
        $this->assertArrayHasKey('accessKeyId', $credentials);
        $this->assertArrayHasKey('secretAccessKey', $credentials);
        $this->assertArrayHasKey('sessionToken', $credentials);
        $this->assertArrayHasKey('url', $credentials);
    }

    /** @test */
    public function create_upload_from_url()
    {
        $this->dataset = Mapbox::datasets()->create();
        Mapbox::features($this->dataset['id'], '123')
            ->insert($this->getFeature());

        $this->tileset = $this->getTileset();

        $this->upload = Mapbox::uploads()->create([
            'tileset' => $this->tileset,
            'url' => implode('/', [
                'mapbox://datasets',
                config('laravel-mapbox.username'),
                $this->dataset['id'],
            ]),
            'name' => $this->tileset,
        ]);

        $this->assertValidUploadResponse($this->upload);
        $this->assertEquals(config('laravel-mapbox.username'), $this->upload['owner']);
    }

    /** @test */
    public function create_upload_from_dataset_id()
    {
        $this->dataset = Mapbox::datasets()->create();
        Mapbox::features($this->dataset['id'], '123')
            ->insert($this->getFeature());

        $this->tileset = $this->getTileset();

        $this->upload = Mapbox::uploads()->create([
            'tileset' => $this->tileset,
            'dataset' => $this->dataset['id'],
            'name' => $this->tileset,
        ]);

        $this->assertValidUploadResponse($this->upload);
        $this->assertEquals(config('laravel-mapbox.username'), $this->upload['owner']);
    }

    /** @test */
    public function retrieve_upload_status()
    {
        $this->dataset = Mapbox::datasets()->create();
        Mapbox::features($this->dataset['id'], '123')
            ->insert($this->getFeature());

        $this->tileset = $this->getTileset();

        $this->upload = Mapbox::uploads()->create([
            'tileset' => $this->tileset,
            'url' => implode('/', [
                'mapbox://datasets',
                config('laravel-mapbox.username'),
                $this->dataset['id'],
            ]),
            'name' => $this->tileset,
        ]);

        $response = Mapbox::uploads($this->upload['id'])->get();

        $this->assertValidUploadResponse($response);
    }

    /** @test */
    public function list_recent_upload_statuses()
    {
        // This is tested implicitly in most of the other tests

        $response = Mapbox::uploads()->list();

        $this->assertTrue(is_array($response));
    }

    /** @test */
    public function delete_upload()
    {
        $this->dataset = Mapbox::datasets()->create();
        Mapbox::features($this->dataset['id'], '123')
            ->insert($this->getFeature());

        $this->tileset = $this->getTileset();

        $this->upload = Mapbox::uploads()->create([
            'tileset' => $this->tileset,
            'url' => implode('/', [
                'mapbox://datasets',
                config('laravel-mapbox.username'),
                $this->dataset['id'],
            ]),
            'name' => $this->tileset,
        ]);

        while (isset($this->upload['complete']) && $this->upload['complete'] != true) {
            sleep(1);

            $this->upload = Mapbox::uploads($this->upload['id'])->get();
        }

        $response = Mapbox::uploads($this->upload['id'])->delete();

        $uploads = Mapbox::uploads()->list();

        $this->assertTrue($response);
        $this->assertFalse(in_array($this->upload['id'], array_column($uploads, 'id')));

        $this->upload = null;
    }
}
