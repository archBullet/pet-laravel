<?php

namespace Tests;

use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected Faker $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = $this->app->make(Faker::class);
    }
}
