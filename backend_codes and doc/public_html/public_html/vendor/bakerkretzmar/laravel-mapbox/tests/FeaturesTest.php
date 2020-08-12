<?php

namespace Bakerkretzmar\LaravelMapbox\Tests;

use Mapbox;

class FeaturesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->dataset = Mapbox::datasets()->create();
    }

    protected function tearDown(): void
    {
        Mapbox::datasets($this->dataset['id'])->delete();

        parent::tearDown();
    }

    /** @test */
    public function list_features()
    {
        Mapbox::datasets($this->dataset['id'])
            ->features('123')
            ->insert($this->getFeature());

        $response = Mapbox::datasets($this->dataset['id'])
                        ->features()
                        ->list();

        $this->assertEquals('FeatureCollection', $response['type']);
        $this->assertValidFeatureResponse($response['features'][0]);
    }

    /** @test */
    public function retrieve_feature()
    {
        Mapbox::datasets($this->dataset['id'])
            ->features('123')
            ->insert($this->getFeature());

        $response = Mapbox::datasets($this->dataset['id'])
                        ->features('123')
                        ->get();

        $this->assertValidFeatureResponse($response);
    }

    /** @test */
    public function access_features_directly_using_shortcut()
    {
        Mapbox::features($this->dataset['id'], '123')
            ->insert($this->getFeature());

        $response = Mapbox::features($this->dataset['id'], '123')
                        ->get();

        $this->assertValidFeatureResponse($response);
    }

    /** @test */
    public function insert_feature()
    {
        $response = Mapbox::datasets($this->dataset['id'])
                        ->features('123')
                        ->insert($this->getFeature());

        $this->assertValidFeatureResponse($response);
        $this->assertEquals('123', $response['id']);
        $this->assertEquals('Feature', $response['type']);
        $this->assertEquals('Polygon', $response['geometry']['type']);
    }

    /** @test */
    public function delete_feature()
    {
        Mapbox::datasets($this->dataset['id'])
            ->features('123')
            ->insert($this->getFeature());

        $response = Mapbox::datasets($this->dataset['id'])
                        ->features('123')
                        ->delete();

        $this->assertTrue($response);
    }
}
