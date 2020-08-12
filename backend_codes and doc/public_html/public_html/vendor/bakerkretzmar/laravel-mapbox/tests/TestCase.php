<?php

namespace Bakerkretzmar\LaravelMapbox\Tests;

use Mapbox;
use Bakerkretzmar\LaravelMapbox\LaravelMapboxServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected $dataset;

    protected $tileset;

    protected $upload;

    protected function getPackageProviders($app)
    {
        return [LaravelMapboxServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return ['Mapbox' => 'Bakerkretzmar\LaravelMapbox\Facades\Mapbox'];
    }

    protected function getEnvironmentSetUp($app)
    {
        if (empty(getenv('CI'))) {
            \Dotenv\Dotenv::create(__DIR__ . '/..', '.env.testing')->load();
        }

        config(['laravel-mapbox.username' => getenv('MAPBOX_USERNAME')]);
        config(['laravel-mapbox.token' => getenv('MAPBOX_TOKEN')]);
    }

    protected function assertValidDatasetResponse(array $response)
    {
        $this->assertArrayHasKey('owner', $response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('description', $response);
        $this->assertArrayHasKey('created', $response);
        $this->assertArrayHasKey('modified', $response);
        $this->assertArrayHasKey('features', $response);
        $this->assertArrayHasKey('size', $response);
        $this->assertArrayHasKey('bounds', $response);
    }

    protected function assertValidFeatureResponse(array $response)
    {
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('type', $response);
        $this->assertArrayHasKey('geometry', $response);
        $this->assertArrayHasKey('properties', $response);
    }

    protected function assertValidUploadResponse(array $response)
    {
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('complete', $response);
        $this->assertArrayHasKey('error', $response);
        $this->assertArrayHasKey('created', $response);
        $this->assertArrayHasKey('modified', $response);
        $this->assertArrayHasKey('tileset', $response);
        $this->assertArrayHasKey('owner', $response);
        $this->assertArrayHasKey('progress', $response);
    }

    protected function cleanupTestDatasets(array $datasets)
    {
        foreach ($datasets as $id) {
            Mapbox::datasets($id)->delete();
        }
    }

    protected function getTileset()
    {
        return 'test_' . str_replace(['.', ' '], '-', microtime());
    }

    protected function getFeature()
    {
        return [
            'id' => '123',
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Polygon',
                'coordinates' => [
                    [
                        [ 100, 0 ],
                        [ 101, 0 ],
                        [ 101, 1 ],
                        [ 100, 1 ],
                        [ 100, 0 ],
                    ],
                ],
            ],
            'properties' => [
                'property' => 'value',
            ],
        ];
    }
}
