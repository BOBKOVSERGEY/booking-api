<?php

namespace Tests;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /*public function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class); // THIS IS THE LINE WE NEED
    }*/
}
