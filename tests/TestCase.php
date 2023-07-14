<?php

namespace Tests;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    public string $url = '/api/v1';
    use CreatesApplication;

   public function setUp(): void
    {
        parent::setUp();

        //$this->seed(DatabaseSeeder::class); // THIS IS THE LINE WE NEED
    }
    /*

    public function tearDown(): void
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }*/
}
