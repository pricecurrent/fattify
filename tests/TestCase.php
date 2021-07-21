<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Arr;
use Illuminate\Testing\Assert as PHPUnit;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        TestResponse::macro('assertJsonHasModel', function ($model) {
            $json = collect(Arr::get($this->json(), 'data', $this->json()));


            PHPUnit::assertTrue(
                $json->contains(fn ($item) => $item[$model->getKeyName()] == $model->getKey()),
                "Model with {$model->getKeyName()} of {$model->getKey()} was not found on the payload."
            );
        });

        TestResponse::macro('assertJsonDoesntHaveModel', function ($model) {
            $json = collect(Arr::get($this->json(), 'data', $this->json()));

            PHPUnit::assertFalse(
                $json->contains(fn ($item) => $item[$model->getKeyName()] == $model->getKey()),
                "Model with {$model->getKeyName()} of {$model->getKey()} was unexpectedly found on the payload."
            );
        });
    }
}
