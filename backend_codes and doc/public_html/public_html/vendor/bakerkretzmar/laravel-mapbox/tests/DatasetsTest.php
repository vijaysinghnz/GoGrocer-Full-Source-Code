<?php

namespace Bakerkretzmar\LaravelMapbox\Tests;

use Mapbox;

class DatasetsTest extends TestCase
{
    protected function tearDown(): void
    {
        if ($this->dataset) {
            Mapbox::datasets($this->dataset['id'])
                ->delete();
        }

        parent::tearDown();
    }

    /** @test */
    public function list_datasets()
    {
        $response = Mapbox::datasets()
                        ->list();

        $this->assertValidDatasetResponse($response[0]);
    }

    /** @test */
    public function create_dataset()
    {
        $this->dataset = Mapbox::datasets()
                            ->create();

        $this->assertValidDatasetResponse($this->dataset);
    }

    /** @test */
    public function create_dataset_with_metadata()
    {
        $this->dataset = Mapbox::datasets()->create([
            'name' => 'test dataset name',
            'description' => 'test dataset description',
        ]);

        $this->assertValidDatasetResponse($this->dataset);
        $this->assertEquals('test dataset name', $this->dataset['name']);
        $this->assertEquals('test dataset description', $this->dataset['description']);
    }

    /** @test */
    public function retrieve_dataset()
    {
        $this->dataset = Mapbox::datasets()->create();

        $response = Mapbox::datasets($this->dataset['id'])
                        ->get();

        $this->assertValidDatasetResponse($response);
        $this->assertEquals($this->dataset['id'], $response['id']);
    }

    /** @test */
    public function update_dataset()
    {
        $this->dataset = Mapbox::datasets()->create();

        $response = Mapbox::datasets($this->dataset['id'])->update([
            'name' => 'updated name',
            'description' => 'updated description',
        ]);

        $this->assertValidDatasetResponse($response);
        $this->assertEquals('updated name', $response['name']);
        $this->assertEquals('updated description', $response['description']);
    }

    /** @test */
    public function delete_dataset()
    {
        $this->dataset = Mapbox::datasets()->create([]);

        $response = Mapbox::datasets($this->dataset['id'])->delete();

        $datasets = Mapbox::datasets()->list();

        $this->assertEquals(true, $response);
        $this->assertFalse(in_array($this->dataset['id'], array_column($datasets, 'id')));

        $this->dataset = null;
    }
}
