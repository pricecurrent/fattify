<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use Illuminate\Testing\Assert as PHPUnit;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

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
        TestResponse::macro('assertJsonSortedById', function (array $models) {
            $json = collect(Arr::get($this->json(), 'data', $this->json()));

            foreach ($models as $index => $model) {
                $this->assertJsonHasModel($model);
                $jsonModel = $json[$index] ?? null;
                PHPUnit::assertEquals($jsonModel['id'] ?? null, $model->id, "Model is not found or is not on its expected place in the payload");
            }
        });

        TestResponse::macro('assertJsonDoesntHaveModel', function ($model) {
            $json = collect(Arr::get($this->json(), 'data', $this->json()));

            PHPUnit::assertFalse(
                $json->contains(fn ($item) => $item[$model->getKeyName()] == $model->getKey()),
                "Model with {$model->getKeyName()} of {$model->getKey()} was unexpectedly found on the payload."
            );
        });
    }

    public function assertCarbon(Carbon $actual, Carbon $expected)
    {
        PHPUnit::assertEqualsWithDelta($actual->timestamp, $expected->timestamp, 3, 'Two dates are not equal');
    }

    public function markTestPassed()
    {
        $this->assertTrue(true);
    }
}
